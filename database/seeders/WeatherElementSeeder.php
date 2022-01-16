<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeatherElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scales = [
            'temperature' => [
                'fahrenheit',
                'celsius',
                'kelvin'
            ],
            'humidity' => [
                'g.m-3',
                'g.kg-1'

            ],
            'wind' => [
                'knot'
            ]
        ];

        foreach($scales as $key => $values) {
            foreach($values as $value){
                DB::table('weather_elements')->insert([
                    'type' => $key,
                    'scale' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}