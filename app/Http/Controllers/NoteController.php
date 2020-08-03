<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreRequest;
use App\Note;
use App\NoteDetail;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;


class NoteController extends Controller
{
    protected const DEFAULT = 1;
    public function index()
    {
        $todos = Note::all();
        $status = Status::all();
        $redis = Redis::connection();
        $redis->set('todoList', "$todos");

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
            DB::beginTransaction();
            $todo = new Note();
            $todo->name = $request->name;
            $todo->category_id = $request->category;
            $todo->status = self::DEFAULT;
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
        } catch (\Exception $exception) {
            DB::rollBack();

            return $exception->getMessage();
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

    public function recent()
    {
        $todos = json_decode(Redis::get('recent'), true);

        return view('recent', compact('todos'));
    }

    public function clearCache()
    {
        Redis::del('recent');

        return redirect()->route('index');
    }

    public function getTodoApi()
    {
        $todos = Note::all();

        return response()->json([
            'status' => 200,
            'message' => 'Get All todo',
            'todos' => $todos
        ]);
    }

    public function addTodo($request)
    {
        $todo = new Note();
        $todo->name = $request->name;
        $todo->category_id = $request->category;
        $todo->status = self::DEFAULT;
        $todo->user_id = $request->user_id;
        $todo->save();
    }

    public function addTodoDetail($request)
    {
        $todoDetail = new NoteDetail();
        $todoDetail->note_id = $request->note_id;
        $todoDetail->desc = $request->desc;
        $todoDetail->save();
    }

    public function storeApi(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->addTodo($request);
            $this->addTodoDetail($request);
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'add completed'
            ]);
        } catch (\Exception $exception)
        {
            DB::rollBack();

            return response()->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ]);
        }


    }
}
