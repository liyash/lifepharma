<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\User;

class AddAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where("id", 1)->delete();
        User::create([
            "id" => 1,
            "name" => "Administrator",
            'username' => "sadmin",
            'email' => "admin@lifepharma.ae",
            'password' => \Hash::make('password')

        ]);
    }
}
