<?php

use Illuminate\Database\Seeder;

class AnimalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Animal::truncate();

        \App\Animal::create(
            [
                'user_id' => '1',
                'animal_type_id' => '1',
                'hunger_count' => 70,
                'hunger_system_min' => 0,
                'hunger_user_min' => -1,
                'hunger_danger_min' => -1,
                'sleep_count' => 70,
                'sleep_system_min' => 0,
                'sleep_user_min' => -1,
                'care_count' => 70,
                'care_system_min' => 0,
                'care_user_min' => -1,
                'joy_user_min' => -1,
            ]
        );

        \App\Animal::create(
            [
                'user_id' => '1',
                'animal_type_id' => '2',
                'hunger_count' => 100,
                'hunger_system_min' => 0,
                'hunger_user_min' => -1,
                'hunger_danger_min' => -1,
                'sleep_count' => 100,
                'sleep_system_min' => 0,
                'sleep_user_min' => -1,
                'care_count' => 100,
                'care_system_min' => 0,
                'care_user_min' => -1,
                'joy_user_min' => -1,
            ]
        );

        \App\Animal::create(
            [
                'user_id' => '2',
                'animal_type_id' => '3',
                'hunger_count' => 100,
                'hunger_system_min' => 0,
                'hunger_user_min' => -1,
                'hunger_danger_min' => -1,
                'sleep_count' => 100,
                'sleep_system_min' => 0,
                'sleep_user_min' => -1,
                'care_count' => 100,
                'care_system_min' => 0,
                'care_user_min' => -1,
                'joy_user_min' => -1,
            ]
        );

        \App\Animal::create(
            [
                'user_id' => '2',
                'animal_type_id' => '4',
                'hunger_count' => 100,
                'hunger_system_min' => 0,
                'hunger_user_min' => -1,
                'hunger_danger_min' => -1,
                'sleep_count' => 100,
                'sleep_system_min' => 0,
                'sleep_user_min' => -1,
                'care_count' => 100,
                'care_system_min' => 0,
                'care_user_min' => -1,
                'joy_user_min' => -1,
            ]
        );

    }
}
