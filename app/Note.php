<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class Note extends Model
{
    protected $table = 'notes';
    protected const DEFAULT = 1;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function noteDetail()
    {
        return $this->hasMany('App\NoteDetail','note_id');
    }

    /**
     * @return Note[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Note::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findNote($id)
    {
        return Note::find($id);
    }

    public function createNote($name, $category )
    {
        $todo = new Note();
        $todo->name = $name;
        $todo->category_id = $category;
        $todo->status = self::DEFAULT;
        $user = Auth::user();
        $todo->user_id = $user->id;
        $todo->save();
        return $todo;
    }

    public function updateNote($id, $name, $category)
    {
        $todo = $this->findNote($id);
        $todo->name = $name;
        $todo->category_id = $category;
        $todo->save();
    }

    public function destroyNote($todo)
    {
        $todo->delete();
    }

    public function searchNote($keyword)
    {
        return Note::where('name', 'LIKE', '%' . $keyword . '%')->get();
    }

    public function updateStatus($id, $status)
    {
        $todo = Note::find($id);
        $todo->status = $status;
        $todo->save();
    }
    public function addTodo($name, $category, $user_id)
    {
        $todo = new Note();
        $todo->name = $name;
        $todo->category_id = $category;
        $todo->status = self::DEFAULT;
        $todo->user_id = $user_id;
        $todo->save();
    }

    public function addTodoDetail($note_id, $desc)
    {
        $todoDetail = new NoteDetail();
        $todoDetail->note_id = $note_id;
        $todoDetail->desc = $desc;
        $todoDetail->save();
    }

}
