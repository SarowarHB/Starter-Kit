<?php

namespace App\Listeners\Auth;

use App\Models\LoginHistory;
use App\Library\Helper;

class LoggedListener
{

    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        $user = $event->user;
        $success = $event->success;
        $geo = Helper::getGeoInfo();
        $history = new LoginHistory();
        $history->email = $user->email;
        $history->status = $success ? 'success' : 'failed';
        if($success)
            $history->user_id = $user->id;
        else
            $history->password = $user->password;

        if($geo)
        {
            $history->ip = isset($geo['query']) ? $geo['query'] : null;
            $history->country = isset($geo['country']) ? $geo['country'] : null;
            $history->region = isset($geo['regionName']) ? $geo['regionName'] : null;
            $history->city = isset($geo['city']) ? $geo['city'] : null;
        }

        $history->geo_details = json_encode($geo);
        $history->save();
    }
}
