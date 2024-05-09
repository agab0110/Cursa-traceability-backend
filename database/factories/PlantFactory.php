<?php

namespace Database\Factories;

use App\Models\Forest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plant>
 */
class PlantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lat' => 1.0,
            'lng' => 2.0,
            'woody_species' => 'Quercia',
            'diameter' => random_int(1, 50),
            'propagation' => 'Sconosciuta',
            'georeferenzial_date' => Carbon::now(),
            'forest_id' => Forest::factory(),
        ];
    }
}
