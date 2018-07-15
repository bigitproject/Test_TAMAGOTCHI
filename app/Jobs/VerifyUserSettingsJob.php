<?php

namespace App\Jobs;

use App\Animal;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class VerifyUserSettingsJob implements ShouldQueue
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
        $this->updateMin();
    }

    private function updateMin(){
        DB::table('animals')->where('hunger_user_min', '<>', -1)->increment('hunger_user_min');
        DB::table('animals')->where('sleep_user_min', '<>', -1)->increment('sleep_user_min');
        DB::table('animals')->where('care_user_min', '<>', -1)->increment('care_user_min');
        DB::table('animals')->where('joy_user_min', '<>', -1)->increment('joy_user_min');

        $this->cancelBlockHunger();
        $this->cancelBlockSleep();
        $this->cancelBlockCare();
        $this->cancelBlockJoy();
    }

    private function cancelBlockHunger(){
        $controlTime = 5;
        $userMin = 'hunger_user_min';
        $message = 'cancel_block_hunger';

        $this->cancelBlock($controlTime, $userMin, $message);
    }

    private function cancelBlockSleep(){
        $controlTime = 10;
        $userMin = 'sleep_user_min';
        $message = 'cancel_block_sleep';

        $this->cancelBlock($controlTime, $userMin, $message);
    }

    private function cancelBlockCare(){
        $controlTime = 5;
        $userMin = 'care_user_min';
        $message = 'cancel_block_care';

        $this->cancelBlock($controlTime, $userMin, $message);
    }

    private function cancelBlockJoy(){
        $controlTime = 20;
        $userMin = 'joy_user_min';
        $message = 'cancel_block_joy';

        $this->cancelBlock($controlTime, $userMin, $message);
    }

    private function cancelBlock($controlTime, $userMin, $message){

        $animals = Animal::where($userMin, '>=', $controlTime)->get();

        Animal::where($userMin, '>=', $controlTime)->update([$userMin => -1]);

        if($animals){
            $groupedAnimalsByUser = $animals->groupBy('user_id')->toArray();

            foreach ($groupedAnimalsByUser as $key_user_id => $item){
                //отсылка каждому пользователю сообщения об отмене блокирования
                \App\Events\PublicChat::dispatch($message, $item, $key_user_id);
            }
        }
    }

}
