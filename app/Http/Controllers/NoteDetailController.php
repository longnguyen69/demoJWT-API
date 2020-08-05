<?php

namespace App\Http\Controllers;

use App\Note;
use App\NoteDetail;
use App\Recent\Recent;
use Illuminate\Http\Request;

class NoteDetailController extends Controller
{
    protected $note;
    protected $noteDetail;

    public function __construct(Note $note, NoteDetail $noteDetail)
    {
        $this->note = $note;
        $this->noteDetail = $noteDetail;
    }

    public function show(Recent $recent, $note_id)
    {
        $todo = $this->noteDetail->findByNoteId($note_id);
        $note = $this->note->findNote($note_id);
        $recent->add($note);

        return view('todoDetail',compact('todo'));
    }

    public function store($note_id, Request $request)
    {
        $this->noteDetail->updateNoteDetail($note_id, $request->desc);

        return back();
    }
}
