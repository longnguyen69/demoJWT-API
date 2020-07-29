<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function noteDetail()
    {
        return $this->hasOne('App\NoteDetail','note_id');
    }
}
