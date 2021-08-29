<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Owner',
            'email' => 'admin@zlodev.com',
            'is_active' => true,
            'role_id' => Role::getRoleBySlug('admin')
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moder@zlodev.com',
            'role_id' => Role::getRoleBySlug('moderator')
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Editor',
            'email' => 'editor@zlodev.com',
            'role_id' => Role::getRoleBySlug('editor')
        ]);
    }
}
