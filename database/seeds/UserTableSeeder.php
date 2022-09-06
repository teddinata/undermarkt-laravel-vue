<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin Undermarkt',
            'email'     => 'teddinata@creazylab.id',
            'password'  => bcrypt('password'),
            'roles'     => 'ADMIN'
        ]);
    }
}
