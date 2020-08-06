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

    /**
     * @param Recent $recent
     * @param $note_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Recent $recent, $note_id)
    {
        $todo = $this->noteDetail->findByNoteId($note_id);
        $note = $this->note->findNote($note_id);
        $recent->add($note);

        return view('note/todoDetail',compact('todo'));
    }

    /**
     * @param $note_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($note_id, Request $request)
    {
        $this->noteDetail->updateNoteDetail($note_id, $request->desc);

        return back();
    }
}
