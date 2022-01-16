<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PredictionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $scales = [
            'fahrenheit',
            'celsius',
            'kelvin',
            'g.m-3',
            'g.kg-1',
            'knot'
        ];

        return [
            'scale' => $this->faker->randomElement($scales),
            'city' => $this->faker->city,
            'date' => $this->faker->date($format = 'Ymd', $max = 'now'),
            'time' => $this->faker->time($format = 'H:i', $max = 'now'),
            'value' => $this->faker->regexify('[0-9]{1,2}')
        ];
    }
}