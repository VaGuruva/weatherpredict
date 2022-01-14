<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PredictionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Prediction::factory(15)->create();
    }
}
