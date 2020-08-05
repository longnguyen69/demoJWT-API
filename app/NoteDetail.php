<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteDetail extends Model
{
    protected $table = 'noteDetails';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    /**
     * @param $id_note
     */
    public function createNoteDetail($id_note)
    {
        $todoDetail = new NoteDetail();
        $todoDetail->note_id = $id_note;
        $todoDetail->save();
    }

    /**
     * @param $note_id
     * @return mixed
     */
    public function findByNoteId($note_id)
    {
        return NoteDetail::where('note_id', '=', $note_id)->first();
    }

    /**
     * @param $note_detail
     */
    public function destroyNoteDetail($note_detail)
    {
        $note_detail->delete();
    }

    /**
     * @param $note_id
     * @param $desc
     */
    public function updateNoteDetail($note_id, $desc)
    {
        $note = $this->findByNoteId($note_id);
        $note->desc = $desc;
        $note->save();
    }
}
