<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class LogActivity extends Controller
{
    public function getLog()
    {
        $logs = Activity::paginate(25);

        return view('log/logActivity',compact('logs'));
    }
}
