<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class LogActivity extends Controller
{
    public function getLog()
    {
        $logs = Activity::all();
        return view('logActivity',compact('logs'));
    }
}
