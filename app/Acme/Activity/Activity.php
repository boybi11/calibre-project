<?php 

namespace Acme\Activity;

use Illuminate\Support\Collection;
use App\Activity as ActivityModel;
use Illuminate\Support\Facades\Auth;

class Activity
{
    public function create($log)
    {
        $activity = new ActivityModel;

        $activity->user_id = Auth::user()->id;
        $activity->log = Auth::user()->name . ' ' . $log;
        // $activity->save(); //TEMPORARILY REMOVED SINCE ACTIVITY LOGGING IS PUT INSIDE BASE MODEL
    }
}