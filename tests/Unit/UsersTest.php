<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use  RefreshDatabase;

    /**
     * User class is successfully exist
     *
     * @test
     */
    public function has_instance()
    {
        $this->assertInstanceOf('App\User', factory(User::class)->create());
    }
}
