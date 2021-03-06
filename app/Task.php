<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable=['title','description','status','user_id'];


    public function labels(){
        return $this->hasMany(Label::class);
    }
}
