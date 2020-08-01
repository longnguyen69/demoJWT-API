<?php


namespace App\Recent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class Recent
{
    public $items = null;

    public function __construct()
    {
        $this->items = Redis::get('recent') ? Redis::get('recent') : null;
    }

    public function add($todo)
    {
        if (Auth::check()) {
            if (empty($this->items)) {
                $this->items[$todo->id] = $todo;
                Redis::set('recent', $this->items);
            } else {
                $arr = json_decode($this->items, true);
                $arr[$todo->id] = $todo;
                Redis::set('recent', json_encode($arr));
            }
        }
    }
}
