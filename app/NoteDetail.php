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
}
