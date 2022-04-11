<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable=['id','name','task_id'];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
