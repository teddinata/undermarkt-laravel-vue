<?php

namespace Database\Seeds;


use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        // seeders
        $this->call(UsersTableSeeder::class);

        // IndoRegion
        // $this->call(IndoRegionProvinceSeeder::class);
        // $this->call(IndoRegionRegencySeeder::class);
        // $this->call(IndoRegionDistrictSeeder::class);
        // $this->call(IndoRegionVillageSeeder::class);
        // $this->call(IndoRegionSeeder::class);

    }
}
