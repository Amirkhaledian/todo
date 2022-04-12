<?php

namespace Tests\Feature;

use App\Label;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelTest extends TestCase
{
    /**
     * @test
     */
    public function create_new_label_withot_login_a_user()
    {
        $task=Task::inRandomOrder()->first();
        $this->postJson(route('label.create',$task->id))->assertUnauthorized();
    }

    /**
     * @test
     */
    public function create_new_label_withot_validation()
    {
        ($this->loginUser());
        $task=Task::inRandomOrder()->first();
        $this->postJson(route('label.create',$task->id))->assertStatus(422);
    }

    /**
     * @test
     */
    public function create_new_label()
    {
        $this->loginUser();
        $task=Task::inRandomOrder()->first();
        $label = factory(Label::class)->make(['task_id'=>$task->id])->toArray();
        $this->postJson(route('label.create',$label['task_id']),$label)->assertStatus(200);
    }

    /**
     * @test
     */
    public function create_repeatred_label()
    {
        ($this->loginUser());
        $label=Label::first()->toArray();
        $task=Task::inRandomOrder()->first();
        $this->postJson(route('label.create', $task->id), $label)->assertStatus(422);
    }

    /**
     * @test
     */
    public function add_one_plus_n_label_to_a_task()
    {
        ($this->loginUser());
        $task=Task::inRandomOrder()->first();
        $labels = factory(Label::class)->make(['task_id' => $task->id],rand(0,100))->toArray();
        $this->postJson(route('label.create',$task->id), $labels)->assertStatus(200);
    }

    /**
     * @test
     */
    public function get_list_of_labels_through_a_task_of_a_user()
    {
        $this->loginUser();
        $this->getJson(route('label.all'))->assertStatus(200);
    }


}
