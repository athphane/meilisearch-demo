<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $multiplier = 5;

        // write a seeder that will create 10 legislation, add 10 consolidations to each, and adds 20 sections to each consolidation
        $legislations = \App\Models\Legislation::factory($multiplier)->create();

        foreach ($legislations as $legislation) {
            $consolidations = \App\Models\Consolidation::factory($multiplier * 5)->create([
                'legislation_id' => $legislation->id
            ]);

            foreach ($consolidations as $consolidation) {
                \App\Models\Section::factory($multiplier * 10)->create([
                    'consolidation_id' => $consolidation->id
                ]);
            }
        }


    }
}
