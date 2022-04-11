<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Http\Resources\Label as LabelResource;
use App\Label;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabelController extends Controller
{

    public function index(){

        $labels=Label::with('task')->whereHas('task',function($q){
            return $q->where('user_id',auth()->user()->id);
        })->get();

        return LabelResource::collection($labels);
    }

    public function create(LabelRequest $request, Task $task)
    {
        $inputs=$request->all();
        $inputs['task_id']=$task->id;
        $label=Label::create($inputs);

        if($label){
            return response()->json(['status'=>'success','message'=>'label created Sucessfully','data'=>$label]);
        }else{
            return response()->json(['status'=>'error','message'=>'error occurred in create label. please try again']);
        }
    }

}
