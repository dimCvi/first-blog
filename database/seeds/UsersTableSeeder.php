<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'bla',
            'email' => 'dimitrijecvijic0@gmail.com',
            'password' => Hash::make('dimCvi')
        ]);
    }
}
