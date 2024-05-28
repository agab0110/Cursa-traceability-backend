<?php

namespace Database\Factories;

use App\Models\Lot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => 1,
            'lot_id' => Lot::factory(),
            'lenght' => 1,
            'median' => 1,
            'cut_date' => Carbon::now()
        ];
    }
}
