<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public function loginUser()
    {
        $user=User::inRandomOrder()->first();
        if(!$user){
            $user=factory(User::class)->create();
        }

        $this->actingAs($user, 'api');
        return $user;
    }
}
