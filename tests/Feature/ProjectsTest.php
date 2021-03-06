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
     * Visitor can see all project
     *
     * @test
     */
    public function user_can_view_all_projects()
    {
        $this->get('/api/projects')
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    /**
     * Visitor can create a new project
     *
     * @test
     */
    public function can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(Project::$statuses),
        ];

        $request = $this->post('/api/projects', $data);
        $request->assertStatus(201);

        $this->assertDatabaseHas('projects', $data);

        $request->assertJsonStructure([
            'data' => [
                'name',
                'status',
                'description',
                'id',
            ],
        ]);
    }

    /**
     * Visitor can't create a project with a wrong status
     * @test
     */
    public function cant_create_with_wrong_status()
    {
        $project = factory(Project::class)->raw(['status' => $this->faker->word]);
        $this->post('/api/projects', $project)->assertStatus(422)->assertJsonStructure([
            'errors' => [
                'status',
            ],
        ]);
    }

    /**
     * User can't create a project without providing a `name` field
     *
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
     * User can't create a project without providing `description`
     *
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

    /**
     * User cant update project
     *
     * @test
     */
    public function a_project_can_update()
    {
        $project = factory(Project::class)->create();

        $newData = [
            'name' => $this->faker->sentence,
            'description' => 'Changed',
        ];

        $this->put('/api/projects/' . $project->id, $newData)->assertStatus(201);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => $newData['name'],
            'description' => $newData['description'],
        ]);
    }

    /**
     * User can see single project
     *
     * @test
     */
    public function a_user_can_see_single_project()
    {
        $project = factory(Project::class)->create();

        $this->get('/api/projects/' . $project->id)->assertStatus(200)->assertJson([
            'data' => [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
            ],
        ]);
    }

    /**
     * User can delete a project
     * @test
     */
    public function a_user_can_delete_project()
    {
        $project = factory(Project::class)->create();

        $this->delete('/api/projects/' . $project->id)->assertStatus(200);
        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }


    /**
     * Use can change status of the project
     *
     * @test
     */
    public function can_change_status_properly()
    {
        $project = factory(Project::class)->create();
        $statuses = [
            Project::STATUS_ON_HOLD => 'onHoldProject',
            Project::STATUS_FINISHED => 'finishProject',
            Project::STATUS_RUNNING => 'runProject',
            Project::STATUS_PLANNED => 'planProject',
            Project::STATUS_CANCEL => 'cancelProject',
        ];

        foreach ($statuses as $status => $method) {
            $project->{$method}();
            $this->assertDatabaseHas('projects', [
                'id' => $project->id,
                'status' => $status,
            ]);
        }
    }
}
