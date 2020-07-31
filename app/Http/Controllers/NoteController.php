<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreRequest;
use App\Note;
use App\NoteDetail;
use App\Status;
use Dotenv\Loader\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;

class NoteController extends Controller
{
    public function index()
    {
        $todos = Note::all();
        $status = Status::all();
        $redis = Redis::connection();
        $redis->set('todoList', "$todos");
//        dd($redis->get('todoList'));
//        $listTodo = $redis->get('todoList'); // json
//        dd(json_decode($listTodo,true));

        return view('todo', compact('todos', 'status'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {

        try {
            DB::beginTransaction(); // start transaction
            $todo = new Note();
            $todo->name = $request->name;
            $todo->category_id = $request->category;
            $defaul = 1;
            $todo->status = $defaul;
            $user = Auth::user();
            $todo->user_id = $user->id;
            $todo->save();
            $todoDetail = new NoteDetail();
            $todoDetail->note_id = $todo->id;
            $todoDetail->save();
            DB::commit();
            activity()->by($user)->log('add todo');
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
        if ($todo && $todo->status == 3) {
            abort('404');
        }
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
        try {
            DB::beginTransaction();
            $todo = Note::findOrFail($id);
            $note = NoteDetail::where('note_id', '=', $id)->first();
            $note->delete();
            $todo->delete();
            activity()->log('delete todo ' . $todo->name);
            DB::commit();
//            return redirect()->route('index');
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    public function search(Request $request)
    {
        $todos = Note::where('name', 'LIKE', '%' . $request->search . '%')->get();
        return view('todo', compact('todos'));
    }

    public function updateStatus(Request $request, $id)
    {
        $todo = Note::find($id);
        $todo->status = $request->input('status');
        $todo->save();

        return response()->json([
            'success' => true,
            'status' => '200',
            'data' => $todo,
            'status_todo' => $todo->status
        ]);
    }
}
