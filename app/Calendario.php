<?php

namespace App;

use App\Notifications\CalendarioOracao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Calendario extends Model
{
    use Notifiable;


    public function sendNotification()
    {
        $this->notify(new CalendarioOracao($this)); //Pass the model data to the OneSignal Notificator
    }

    public function routeNotificationForOneSignal()
    {
        /*
         * you have to return the one signal player id tat will
         * receive the message of if you want you can return
         * an array of players id
         */

       // return $this->data->user_one_signal_id;

        return $this->data->user_one_signal_id;
    }

}


