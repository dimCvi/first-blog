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
            'name' => 'Dimitrije',
            'surname' => 'Cvijic',
            'email' => 'dimitrijecvijic0@gmail.com',
            'password' => Hash::make('dimCvi'),
            'phone' => '12345678890',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
