<?php


namespace Database\Seeds;

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
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
