<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   /**
     * @test
     */
    public function create_task_when_not_login()
    {
        $this->postJson(route('task.create'))->assertUnauthorized();
    }

      /** @test */
      public function create_task_when_login_and_data_not_validate()
      {
           ($this->loginUser());
          $this->postJson(route('task.create'))->assertStatus(422);
      }
        /**
     * @test
     */
    public function create_task()
    {
        $user = $this->loginUser();
      $data=factory(Task::class)->make(['user_id' => $user['id']])->toArray();
        $this->postJson(route('task.create'), $data)->assertStatus(200);
    }
       /**
     * @test
     */
    public function show_task()
    {
        $user = $this->loginUser();
        $data=factory(Task::class)->create(['user_id' => $user['id']])->toArray();
        $this->getJson(route('task.show',$data['id']))->assertOk();
    }
 /**
     * @test
     */
    public function update_task_when_not_login()
    {
        $data=factory(Task::class)->create()->toArray();

        $this->putJson(route('task.update', [
            'task' => $data['id']
        ]))->assertStatus(401);
    }
     /**
     * @test
     */
    public function update_task()
    {
        $user = $this->loginUser();
        $currentData =factory(Task::class)->create([
            'user_id' => $user['id'],
                  ]);
        $data = factory(Task::class)->make()->toArray();
        $this->putJson(route('task.update', [
            'task' => $currentData['id']
        ]), $data)->assertOk();
    }
 /** @test */
 public function a_user_can_read_all_the_tasks_without_login()
 {
     $task = factory(Task::class)->create();
     $this->getJson(route('task.all'))->assertStatus(401);

 }
 /** @test */
 public function a_user_can_read_all_the_tasks()
 {
    $user = $this->loginUser();
     $task = factory(Task::class)->create();
     $this->getJson(route('task.all'))->assertStatus(401);

 }
}
