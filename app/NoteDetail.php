<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteDetail extends Model
{
    protected $table = 'noteDetails';

    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    public function createNoteDetail($id_note)
    {
        $todoDetail = new NoteDetail();
        $todoDetail->note_id = $id_note;
        $todoDetail->save();
    }

    public function findByNoteId($note_id)
    {
        return NoteDetail::where('note_id', '=', $note_id)->first();
    }

    public function destroyNoteDetail($note_detail)
    {
        $note_detail->delete();
    }

    public function updateNoteDetail($note_id, $desc)
    {
        $note = $this->findByNoteId($note_id);
        $note->desc = $desc;
        $note->save();
    }
}
