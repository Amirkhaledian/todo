<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskStatusRequest;
use App\Http\Resources\Task as ResourcesTask;
use App\Mail\NotificationMail;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{

    public function index()
    {

        ($tasks = Task::where('user_id', auth()->user()->id)->has('labels')->with('labels')->get());

        return ResourcesTask::collection($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateTaskRequest $request)
    {

        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $task = Task::create($inputs);
        if ($task) {
            return response()->json(['status' => 'success', 'message' => 'task created Sucessfully', 'data' => $task]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'error occurred in create task. please try again']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::where([
            ['user_id', auth()->user()->id],
            ['id', $id]
        ])->first();

        if ($task) {
            return response()->json(['status' => 'success', 'data' => $task]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'not found task']);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(EditTaskRequest $request, Task $task)
    {

        $task->update($request->all());

        if ($task) {
            return response()->json(['status' => 'success', 'message' => 'task updated Sucessfully', 'task' => $task]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'error occurred in update task. please try again']);
        }
    }

    public function status(TaskStatusRequest $request, Task $task)
    {
        $result = DB::transaction(function () use ($request, $task) {
            $task->status = $request->status;
            $task->save();

            $dateTime = date('Y-m-d H:i:s');

            if ($task->status == "close") {
                Log::info("task with  id=$task->id change status to $request->status on date tiem $dateTime.");
                Mail::to($request->user()->email)->send(new NotificationMail($task->id, $request->status, $dateTime));
            }

            return true;
        });

        if ($task) {
            return response()->json(['status' => 'success', 'message' => 'task status updated Sucessfully', 'task' => $task]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'error occurred in update task status. please try again']);
        }
    }
}
