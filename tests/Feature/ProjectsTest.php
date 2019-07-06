<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{

    use RefreshDatabase, WithFaker;
    /**
     * @test
     */
    public function user_can_view_all_projects()
    {
        $this->get('/api/projects')
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    /**
     * @test
     */
    public function can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $request = $this->post('/api/projects', $data);
        $request->assertStatus(201);

        $this->assertDatabaseHas('projects', $data);

        $request->assertJsonStructure([
            'data' => [
                'name',
                'description',
                'id',
            ],
        ]);
    }

    /**
     * @test
     */
    public function a_project_require_a_name()
    {
        $project = factory(Project::class)->raw(['name' => '']);
        $this->post('/api/projects', $project)->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'name',
            ],
        ]);
    }

    /**
     * @test
     */
    public function a_project_require_a_description()
    {
        $project = factory(Project::class)->raw(['description' => '']);
        $this->post('/api/projects', $project)->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'description',
            ],
        ]);
    }
}
