<?php

use App\Project;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Project::truncate();

        // $this->call(UsersTableSeeder::class);
        factory(User::class, 50)->create();
        factory(Project::class, 50)->create();
    }
}
