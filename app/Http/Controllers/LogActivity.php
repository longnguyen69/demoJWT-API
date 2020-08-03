<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class LogActivity extends Controller
{
    public function getLog()
    {
        $logs = Activity::all();

        return view('logActivity',compact('logs'));
    }
}
