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
            $item = [
                'todo_id' => $todo->node_id,
                'todo_name' => $todo->desc
            ];
            if (empty($this->items)) {
                $this->items[$todo->note_idset] = $item;
                Redis::set('recent', $this->items);
            } else {
                $arr = json_decode($this->items, true);
                $arr[$todo->note_id] = $item;
                Redis::set('recent', json_encode($arr));
            }
        }
    }
}
