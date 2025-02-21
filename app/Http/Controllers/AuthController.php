<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\AuthResponse;
use App\Models\PasswordSetupMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Authentication"},
     *     summary="Effettua il login dell'utente",
     *     description="Consente all'utente di effettuare il login con le credenziali (email e password). Se il login è corretto, viene generato un token per l'accesso alle API.",
     *     operationId="userLogin",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="remember", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login effettuato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login effettuato"),
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string", example="Api token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Parametri non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Parametri non validi")
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request) {
        $validated = $request->validated();

        if (Auth::attempt(array('email' => $validated['email'], 'password' => $validated['password']), $validated['remember'])) {
            $user = User::where('email', $validated['email'])->first();

            $token = $user->createToken('api_token')->plainTextToken;

            return new AuthResponse('Login effettuato', $user, $token, 200);
        } else {
            throw new ApiException('Parametri non validi', 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Authentication"},
     *     summary="Crea un nuovo utente",
     *     description="Permette la creazione di un nuovo utente. Viene assegnata una password temporanea e inviata un'email all'utente per il settaggio della password.",
     *     operationId="userRegister",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="cf", type="string", example="ABCDEFGHIJKLMNOP"),
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="surname", type="string", example="Doe"),
     *             @OA\Property(property="birth_date", type="date", example="2001-08-15"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="role_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utente creato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Utente creato con successo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dati non validi",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Errore nella creazione dell'utente")
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request) {
        $validated = $request->validated();

        $temporaryPassword = 'password';

        $user = User::create($validated);
        $user->password = $temporaryPassword;
        $user->save();

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addHour()
        ]);

        Mail::to($user->email)->send(new PasswordSetupMail($token));

        return new AuthResponse('Utente creato con successo', null, null, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="Effettua il logout dell'utente",
     *     description="Permette di effettuare il logout, invalidando il token di accesso dell'utente e rimuovendo il token di ricordami.",
     *     operationId="userLogout",
     *     @OA\Response(
     *         response=200,
     *         description="Logout effettuato con successo",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout effettuato")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Utente non autenticato",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Utente non autenticato")
     *         )
     *     )
     * )
     */
    public function logout(Request $request) {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        $user->remember_token = null;
        $user->save();

        return new AuthResponse('Logout effettuato', null, null, 200);
    }
}
