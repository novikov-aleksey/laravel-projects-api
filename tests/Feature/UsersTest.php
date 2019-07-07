<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Visitor can see all users
     *
     * @test
     */
    public function can_view_all_users()
    {
        $this->get('/api/users')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'email'],
                ],
            ]);
    }

    /**
     * Visitor can view a single user
     *
     * @test
     */
    public function can_view_single_user()
    {
        $user = factory(User::class)->create();

        $this->get('/api/users/' . $user->id)->assertStatus(200)->assertJson([
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
            ],
        ]);

    }

    /**
     * Visitor can register a new user
     *
     * @test
     */
    public function can_register_new_user()
    {
        $this->withoutExceptionHandling();

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique('users')->safeEmail,
            'password' => bcrypt('password'),
        ];

        $request = $this->post('/api/users', $data);
        $request->assertStatus(201);
        $this->assertDatabaseHas('users', $data);

        $request->assertJsonStructure([
            'data' => [
                'id',
                'email',
            ],
        ]);
    }

    /**
     * Visitor can't create a user without providing email in proper format
     *
     * @test
     */
    public function an_email_is_required()
    {
        $checkingEmails = [
            '',
            $this->faker->word,
        ];

        foreach ($checkingEmails as $email) {
            $this->requiredFieldIsFilled('email', $email);
        }
    }

    /**
     * Visitor can't create a user without providing strong password (min 6 symbols)
     *
     * @test
     */
    public function password_is_required_and_strong()
    {
        $checkingPasswords = [
            '',
            $this->faker->password(4, 4),
        ];

        foreach ($checkingPasswords as $password) {
            $this->requiredFieldIsFilled('password', $password);
        }
    }

    /**
     * Check required field of the User model
     *
     * @param string $field     Key of the User Model
     * @param string $fakeValue Fake value for this key
     */
    public function requiredFieldIsFilled($field, $fakeValue)
    {
        $user = factory(User::class)->raw([$field => $fakeValue]);

        $this->post('/api/users', $user)->assertStatus(422)->assertJsonStructure([
            'errors' => [
                $field,
            ],
        ]);
    }

    /**
     * Visitor can update a user
     *
     * @test
     */
    public function can_update_user()
    {
        $user = factory(User::class)->create();

        $newData = [
            'email' => $this->faker->email,
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'password' => $this->faker->password,
        ];

        $this->put('/api/users/' . $user->id, $newData)->assertStatus(200);
        $this->assertDatabaseHas('users', $newData);
    }

    /**
     * Visitor can delete a User
     *
     * @test Delete
     */
    public function can_delete_user()
    {
        $user = factory(User::class)->create();

        $this->delete('/api/users/' . $user->id)->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
