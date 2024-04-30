<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TVA>
 */
class TVAFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'libelle' => $this->faker->title(null), // generates a random title like Mr.,
            'valeur'=> $this->faker->randomFloat(2, 0 ,99),//generates a float between 0 and 99/100
        ];
    }
}
