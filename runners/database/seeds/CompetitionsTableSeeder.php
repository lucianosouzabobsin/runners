<?php

use App\Models\Competition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CompetitionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Competition::truncate();
        Schema::enableForeignKeyConstraints();

        $types = ['3', '5', '10', '21', '42'];

        foreach ($types as $type) {
            $competitions = [
                [
                    'type' => $type,
                    'date' => '2021-01-15',
                    'hour_init' => '08:00:00',
                    'min_age' => 18,
                    'max_age' => 25,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'type' => $type,
                    'date' => '2021-01-15',
                    'hour_init' => '08:00:00',
                    'min_age' => 26, 'max_age' => 35,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'type' => $type,
                    'date' => '2021-01-15',
                    'hour_init' => '08:00:00',
                    'min_age' => 36,
                    'max_age' => 45,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'type' => $type,
                    'date' => '2021-01-15',
                    'hour_init' => '08:00:00',
                    'min_age' => 46, 'max_age' => 55,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'type' => $type,
                    'date' => '2021-01-15',
                    'hour_init' => '08:00:00',
                    'min_age' => 56,
                    'max_age' => 100,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
            ];

            Competition::insert($competitions);
        }


    }
}
