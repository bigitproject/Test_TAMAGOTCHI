<?php

use Illuminate\Database\Seeder;
use \App\AnimalsType;

class AnimalTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnimalsType::truncate();

        AnimalsType::create(['name' => 'собака']);
        AnimalsType::create(['name' => 'кот']);
        AnimalsType::create(['name' => 'енот']);
        AnimalsType::create(['name' => 'пингвин']);
    }
}
