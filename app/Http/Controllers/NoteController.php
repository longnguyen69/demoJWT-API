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

    protected $note;
    protected $category;
    protected $status;
    protected $noteDetail;

    public function __construct(Note $note, Category $category, Status $status, NoteDetail $noteDetail)
    {
        $this->note = $note;
        $this->category = $category;
        $this->status = $status;
        $this->noteDetail = $noteDetail;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $todos = $this->note->getAll();
        $status = $this->status->getAll();
        $redis = Redis::connection();
        $redis->set('todoList', "$todos");

        return view('todo', compact('todos', 'status'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = $this->category->getAll();

        return view('create', compact('categories'));
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $note = $this->note->createNote($request->name, $request->category);
            $this->noteDetail->createNoteDetail($note->id);
            DB::commit();
            activity()->by(Auth::user())->log('add todo');
            Session::flash('success', 'Add todo completed!');

            return redirect()->route('show.create');
        } catch (\Exception $exception) {
            DB::rollBack();

            return $exception->getMessage();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $todo = $this->note->findNote($id);
        if ($todo && $todo->status == 3) {
            abort('404');
        }
        $categories = $this->category->getAll();

        return view('editTodo', compact('todo', 'categories'));
    }

    /**
     * @param $id
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, StoreRequest $request)
    {
        $this->note->updateNote($id, $request->name, $request->category);

        return redirect()->route('index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $note = $this->note->findNote($id);
            $noteDetail = $this->noteDetail->findByNoteId($note->id);
            $this->noteDetail->destroyNoteDetail($noteDetail);
            $this->note->destroyNote($note);
            activity()->log('delete todo ' . $note->name);
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
        $todos = $this->note->searchNote($request->search);
        $status = $this->status->getAll();
        return view('todo', compact('todos','status'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $this->note->updateStatus($id, $request->status);
        return response()->json([
            'success' => true,
            'status' => '200',
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recent()
    {
        $todos = json_decode(Redis::get('recent'), true);

        return view('recent', compact('todos'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        Redis::del('recent');

        return redirect()->route('index');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTodoApi()
    {
        $todos = $this->note->getAll();

        return response()->json([
            'status' => 200,
            'message' => 'Get All todo',
            'todos' => $todos
        ]);
    }



    public function storeApi($request)
    {
        try {
            DB::beginTransaction();
            $this->note->addTodo($request->name, $request->category,$request->user_id);
            $this->note->addTodoDetail($request->note_id, $request->desc);
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'add completed'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function find($id)
    {
        try {
            $todo = $this->note->findNote($id);

            return response()->json([
                'code' => 200,
                'message' => 'get todo',
                'todo' => $todo
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
