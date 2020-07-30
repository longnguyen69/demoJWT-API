<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreRequest;
use App\Note;
use App\NoteDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;

class NoteController extends Controller
{
    public function index()
    {
        $todos = Note::all();
        return view('todo', compact('todos'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction(); // start transaction in
        try {
            $todo = new Note();
            $todo->name = $request->name;
            $todo->category_id = $request->category;
            $defaul = 0;
            $todo->status = $defaul;
            $user = Auth::user()->id;
            $todo->user_id = $user;
            $todo->save();
            $todoDetail = new NoteDetail();
            $todoDetail->note_id = $todo->id;
            $todoDetail->save();
            DB::commit();
            Session::flash('success', 'Add todo completed!');
            return redirect()->route('show.create');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        $todo = Note::findOrFail($id);
        $categories = Category::all();
        return view('editTodo', compact('todo', 'categories'));
    }

    public function update($id, StoreRequest $request)
    {
        $todo = Note::findOrFail($id);
        $todo->name = $request->name;
        $todo->category_id = $request->category;
        $todo->status = $request->status;
        $todo->save();
        return redirect()->route('index');
    }

    public function destroy($id)
    {
        $todo = Note::findOrFail($id);
        $note = NoteDetail::where('note_id', '=', $id)->get();
        $note[0]->delete();
        $todo->delete();
        return redirect()->route('index');
    }

    public function search(Request $request)
    {
        $todos = Note::where('name', 'LIKE', '%' . $request->search . '%')->get();
        return view('todo', compact('todos'));
    }
}
