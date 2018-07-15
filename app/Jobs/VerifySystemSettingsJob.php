<?php

namespace App\Jobs;

use App\Animal;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log as Log;

class VerifySystemSettingsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('VERIFY');
        $this->updateSystemMin();
    }

    private function updateSystemMin(){

        DB::table('animals')->increment('hunger_system_min');
        DB::table('animals')->increment('sleep_system_min');
        DB::table('animals')->increment('care_system_min');
        DB::table('animals')->where('hunger_danger_min', '<>', -1)->increment('hunger_danger_min');

        $this->verifyHunger();
        $this->verifySleep();
        $this->verifyCare();
    }

    private function verifyHunger(){

        //характеристика голод  снижается на 1 ед. раз в 10 минут
        $controlTime = 10;
        $systemMin = 'hunger_system_min';
        $characteristic = 'hunger_count';
        $message = 'update_hunger';

        $this->decrementCharacteristic($controlTime, $systemMin, $characteristic, $message);

        $this->verifyDeath();

        $this->verifyHungerDunger();
        $this->cancelHungerDunger();
    }

    private function verifySleep(){

        ////характеристика сон  снижается на 1 ед. раз в 20 минут
        $controlTime = 20;
        $systemMin = 'sleep_system_min';
        $characteristic = 'sleep_count';
        $message = 'update_sleep';

        $this->decrementCharacteristic($controlTime, $systemMin, $characteristic, $message);

    }

    private function verifyCare(){

        //при ненормальных условиях (если сон упал до <5)
        // - характеристика забота снижается быстрее - на 1 ед. раз в 5 минут
        $controlTime1 = 5;
        $systemMin1 = 'care_system_min';
        $characteristic1 = 'care_count';
        $message1 = 'update_care';
        $additionalConditions1 = [ 'sleep_count', '<', 5 ];

        $this->decrementCharacteristic($controlTime1, $systemMin1, $characteristic1, $message1, $additionalConditions1);

        //при нормальных условиях (если сон животного >= 5)
        // - характеристика забота снижается на 1 ед. раз в 15 минут
        $controlTime2 = 15;
        $systemMin2 = 'care_system_min';
        $characteristic2 = 'care_count';
        $message2 = 'update_care';
        $additionalConditions2 = [ 'sleep_count', '>=', 5 ];

        $this->decrementCharacteristic($controlTime2, $systemMin2, $characteristic2, $message2, $additionalConditions2);
    }

    private function decrementCharacteristic($controlTime, $systemMin, $characteristic, $message, $additionalConditions = false){

        if($additionalConditions) {
            $result = DB::table('animals')
                ->where($additionalConditions[0], $additionalConditions[1], $additionalConditions[2])
                ->where($systemMin, '>=', $controlTime)
                ->decrement($characteristic, 1, [$systemMin => 0]);
        }else{
            $result = DB::table('animals')
                ->where($systemMin, '>=', $controlTime)
                ->decrement($characteristic, 1, [$systemMin => 0]);
        }

        $animals = Animal::where($systemMin, '=', 0)->get();
        if($animals){
            $groupedAnimalsByUser = $animals->groupBy('user_id')->toArray();

            foreach ($groupedAnimalsByUser as $key_user_id => $item){
                //отсылка каждому пользователю измененной (уменьшенной) характеристики о животном
                \App\Events\PublicChat::dispatch($message, $item, $key_user_id);
            }
        }
    }

    private function verifyDeath(){

        //Если голод упал до <5, у юзера не накормил животное за 1 час
        //- игрок проигрывает, а питомец погибает
        $animals = Animal::where('hunger_count', '<', 5)->where('hunger_danger_min', '>=', 60)->get();

        if($animals){
            $group = $animals->groupBy('user_id');
            $users_keys = $group->keys()->toArray();

            DB::table('animals')->whereIn('user_id', $users_keys)->delete();

            $groupedAnimalsByUser = $group->toArray();
            foreach ($groupedAnimalsByUser as $key_user_id => $item){
                //отсылка каждому пользователю сообщения о смерти его животных
                \App\Events\PublicChat::dispatch('game_over', $item, $key_user_id);
            }
        }

    }

    private function verifyHungerDunger(){

        //Если голод упал до <5, у юзера есть 1 час, чтобы накормить питомца,
        //поэтому включаем счетчик опасности гибели
        Animal::where('hunger_count', '<', 5)->where('hunger_danger_min', '=', -1)->update(['hunger_danger_min' => 0]);

        $animals = Animal::where('hunger_danger_min', '=', 0)->get();
        if($animals){
            $groupedAnimalsByUser = $animals->groupBy('user_id')->toArray();

            foreach ($groupedAnimalsByUser as $key_user_id => $item){
                //отсылка каждому пользователю предупреждения о его умирающих животных
                \App\Events\PublicChat::dispatch('dunger', $item, $key_user_id);
            }
        }
    }

    private function cancelHungerDunger(){

        //Если голод вначале упал до <5, а сейчас повысился
        //и юзер за 1 час, успел накормить питомца, то
        //отключаем счетчик опасности гибели
        $animals = Animal::where('hunger_count', '>=', 5)->where('hunger_danger_min', '<>', -1)->get();

        Animal::where('hunger_count', '>=', 5)->where('hunger_danger_min', '<>', -1)->update(['hunger_danger_min' => -1]);

        if($animals){
            $groupedAnimalsByUser = $animals->groupBy('user_id')->toArray();

            foreach ($groupedAnimalsByUser as $key_user_id => $item){
                //отсылка каждому пользователю сообщения об снятии опасности смерти его животных
                \App\Events\PublicChat::dispatch('cancel_dunger', $item, $key_user_id);
            }
        }
    }

}