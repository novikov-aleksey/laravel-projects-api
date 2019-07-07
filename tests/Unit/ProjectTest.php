<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Project class is successfully exist
     *
     * @test
     */
    public function has_instance()
    {
        $this->assertInstanceOf('App\Project', factory(Project::class)->create());
    }

}
