<?php


namespace App\Recent;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class Recent
{
    public $items = [];

    public function __construct()
    {
        $this->items = Redis::get('recent') ? Redis::get('recent') : [];
    }

    public function add($todo)
    {
        if (Auth::check()) {
            $item = [
                'todo_id' => $todo->node_id,
                'todo_name' => $todo->desc
            ];
            if ($this->items == null) {
                $this->items[$todo->note_id] = $item;
                Redis::set('recent', $this->items);
            } else {
                $arr = json_decode($this->items, true);
                Redis::set('recent', $arr[$todo->note_id] = $item);
            }
        }
    }
}
