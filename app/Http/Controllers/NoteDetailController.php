<?php

namespace App\Http\Controllers;

use App\Note;
use App\NoteDetail;
use App\Recent\Recent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class NoteDetailController extends Controller
{
    public function show(Recent $recent, $note_id)
    {
        $todo = NoteDetail::where('note_id','=',$note_id)->first();
        $note = Note::find($note_id);
        $recent->add($note);
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
