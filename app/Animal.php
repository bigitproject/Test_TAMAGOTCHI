<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $fillable = [
        'user_id', 'animal_type_id',
        'hunger_count', 'hunger_system_min', 'hunger_user_min', 'hunger_danger_min',
        'sleep_count', 'sleep_system_min', 'sleep_user_min',
        'care_count', 'care_system_min', 'care_user_min',
        'joy_user_min',
    ];
}
