<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Model(M)
        $tasks = Task::all();

        // View(V)
        // return view('tasks.index', [
        //     'tasks' => $tasks,
        // ]);

        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }

        return view('welcome', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'status_name' => 'required|max:10',
            'content' => 'required|max:191',
        ]);

        $request->user()->tasks()->create([
            'content' => $request->content,
            'status_name' => $request->status_name,
        ]);

        return back();

        $task = new Task;
        $task->status_name = $request->status_name;
        $task->content = $request->content;
        $task->user_id = $request->user_id;
        $task->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $taskがnullなら404 Not Foundページが表示される
        // $task = Task::findOrFail($id);
        // \Log::debug('show関数です。');

        $task = Task::find($id);
        // $taskがnullならトップページにリダイレクト
        //if(empty($task)){
        //\Log::debug('エラーが発生しました。');
        // return redirect('/');
        // }

        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = task::find($id);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status_name' => 'required|max:10',
            'content' => 'required|max:191',
        ]);

        $task = Task::find($id);
        $task->status_name = $request->status_name;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task =  \App\Task::find($id);

        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        return back();
        return redirect('/');
    }
}
