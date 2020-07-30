<?php

namespace App\Http\Controllers;

use App\NoteDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteDetailController extends Controller
{
    public function show($note_id)
    {
        $todo = NoteDetail::where('note_id','=',$note_id)->get();
        return view('todoDetail',compact('todo'));
    }

    public function store($note_id, Request $request)
    {
        $note = NoteDetail::where('note_id','=',$note_id)->first();
        $note->desc = $request->desc;
        $note->save();
        return back();
    }
}
