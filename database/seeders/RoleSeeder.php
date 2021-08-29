<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::factory()->create([
            'name' => 'Administrator',
            'slug' => 'admin',
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'Moderator',
            'slug' => 'moderator',
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'Editor',
            'slug' => 'editor',
        ]);
    }
}
