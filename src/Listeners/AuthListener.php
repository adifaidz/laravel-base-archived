<?php

namespace AdiFaidz\Base\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class AuthListener
{
    public function postLogin($event){
        $user = $event->user;
        $user->last_login_at = Carbon::now();
        $user->save();
    }
}
