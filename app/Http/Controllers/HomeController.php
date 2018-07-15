<?php

namespace App\Http\Controllers;

use App\Animal;
use App\Http\Requests\AnimalListRequest;
use App\Http\Requests\AnimalRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function begin()
    {
        return view("begin");
    }

    public function pushEvent()
    {
        \App\Events\PublicChat::dispatch("Hello", "test", auth()->user()->id);
    }

    public function newGame(AnimalListRequest $request, Animal $model)
    {
        $data = $request->except(['_token']);
        $animals = [];
        $model->where('user_id', '=', auth()->user()->id)->delete();

        if($data){
            foreach ($data as $animal_id){
                $animals []= $model->create(
                    [
                        'user_id' => auth()->user()->id,
                        'animal_type_id' => $animal_id,
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

        return response()->json([
            'success'=>true,
            'animals'=>$animals,
            'user_id'=> auth()->user()->id
        ]);
    }


    public function hungr(AnimalRequest $request)
    {
        $data = $request->except(['_token']);

        $animal = $this->updateCountMin($data, 'hunger_count', 'hunger_user_min');

        if($animal) {
            return response()->json(['success' => true, 'animal' => $animal]);
        }else{
            return response()->json(['error' => true, 'animal' => $animal]);
        }

    }

    public function sleep(AnimalRequest $request)
    {
        $data = $request->except(['_token']);

        $animal = $this->updateCountMin($data, 'sleep_count', 'sleep_user_min');

        if($animal) {
            return response()->json(['success' => true, 'animal' => $animal]);
        }else{
            return response()->json(['error' => true, 'animal' => $animal]);
        }

    }

    public function care(AnimalRequest $request)
    {
        $data = $request->except(['_token']);

        $animal = $this->updateCountMin($data, 'care_count', 'care_user_min');

        if($animal) {
            return response()->json(['success' => true, 'animal' => $animal]);
        }else{
            return response()->json(['error' => true, 'animal' => $animal]);
        }

    }

    public function updateCountMin($data, $count, $userTimer){

        Animal::where([
            ['user_id', '=', auth()->user()->id],
            ['animal_type_id', '=', $data['id'] ],
            [$userTimer, '=', -1],
            [$count, '<', 100]
        ])->increment($count, 1, [$userTimer => 0]);

        Animal::where([
            ['user_id', '=', auth()->user()->id],
            ['animal_type_id', '=', $data['id'] ],
            [$userTimer, '=', -1],
            [$count, '=', 100]
        ])->update([$userTimer => 0]);

        $animal =  Animal::where([
            ['user_id', '=', auth()->user()->id],
            ['animal_type_id', '=', $data['id'] ]
        ])->first();

        return $animal;
    }

    public function joy(AnimalRequest $request, Animal $model)
    {
        $data = $request->except(['_token']);

        $animal =  $model->where([ ['user_id', '=', auth()->user()->id],
            ['animal_type_id', '=', $data['id'] ],
            ['joy_user_min', '=', -1],
        ])->first();

        if($animal) {
            $animal->increment('joy_user_min');
            return response()->json(['success' => true, 'animal' => $animal]);
        }else{
            return response()->json(['error' => true, 'animal' => $animal]);
        }

    }

    public function del(Request $request, Animal $model)
    {
        $model->where('user_id', '=', auth()->user()->id)->delete();
    }
}
