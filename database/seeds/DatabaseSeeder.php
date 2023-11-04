<?php

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
        
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRolesTableSeeder::class);
        $this->call(DependenciesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        App\User::flushEventListeners();
        $this->call(UsersTableSeeder::class);
    }
}
