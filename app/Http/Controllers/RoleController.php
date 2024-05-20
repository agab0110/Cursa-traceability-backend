<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified role.
     *
     * @param int $id the id of the role to find
     * @return App\Http\Responses\ApiResponse with the role name
     */
    public function show($id)
    {
        $role = Role::find($id);

        return new ApiResponse('Ruolo trovato', $role->name, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
