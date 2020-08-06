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

    /**
     * @param $name
     * @param $category
     * @return Note
     */
    public function createNote($name, $category )
    {

        $this->name = $name;
        $this->category_id = $category;
        $this->status = self::DEFAULT;
        $user = Auth::user();
        $this->user_id = $user->id;
        $this->save();
        return $this;
    }

    /**
     * @param $id
     * @param $name
     * @param $category
     */
    public function updateNote($id, $name, $category)
    {
        $todo = $this->findNote($id);
        $todo->name = $name;
        $todo->category_id = $category;
        $todo->save();
    }

    /**
     * @param $todo
     */
    public function destroyNote($todo)
    {
        $todo->delete();
    }

    /**
     * @param $keyword
     * @return mixed
     */
    public function searchNote($keyword)
    {
        return Note::where('name', 'LIKE', '%' . $keyword . '%')->get();
    }

    /**
     * @param $id
     * @param $status
     */
    public function updateStatus($id, $status)
    {
        $todo = Note::find($id);
        $todo->status = $status;
        $todo->save();
    }

    /**
     * @param $name
     * @param $category
     * @param $user_id
     */
    public function addTodo($name, $category, $user_id)
    {
        $todo = new Note();
        $todo->name = $name;
        $todo->category_id = $category;
        $todo->status = self::DEFAULT;
        $todo->user_id = $user_id;
        $todo->save();
    }

    /**
     * @param $note_id
     * @param $desc
     */
    public function addTodoDetail($note_id, $desc)
    {
        $todoDetail = new NoteDetail();
        $todoDetail->note_id = $note_id;
        $todoDetail->desc = $desc;
        $todoDetail->save();
    }

}
