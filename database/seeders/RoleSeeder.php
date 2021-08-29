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
        $this->addRoleAdmin();
        $this->addRoleModerator();
        $this->addRoleEditor();
    }

    public function addRoleAdmin()
    {
        Role::updateOrCreate(
            [
                'slug' => 'admin',
            ],
            [
                'name' => 'Administrator',
                'slug' => 'admin',
            ]
        );
    }

    public function addRoleModerator()
    {
        Role::updateOrCreate(
            [
                'slug' => 'moderator',
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
            ],
        );
    }

    public function addRoleEditor()
    {
        Role::updateOrCreate(
            [
                'slug' => 'editor',
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
            ]
        );
    }
}
