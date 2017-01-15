<?php

namespace AdiFaidz\Base\Composers;

use Illuminate\View\View;
use Auth;
class UserComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        if($user != null) {
          $view->with([
            'loggedUser' => $user,
            'loggedUser_profile' => $user->userprofile,
          ]);
        }

    }
}
