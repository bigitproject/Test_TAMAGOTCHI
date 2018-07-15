<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::truncate();

        \App\User::create(
            [
                'name' => 'user1',
                'email' => 'asd@test.net',
                'password' => bcrypt('123'),
            ]
        );

        \App\User::create(
            [
                'name' => 'user2',
                'email' => 'test@test.net',
                'password' => bcrypt('123'),
            ]
        );
    }
}
