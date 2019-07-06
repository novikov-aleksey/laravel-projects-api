<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use  RefreshDatabase;

    /**
     * @test
     */
    public function has_instance()
    {
        $this->assertInstanceOf('App\User', factory(User::class)->create());
    }
}
