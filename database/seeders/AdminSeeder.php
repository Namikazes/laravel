<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    const ADMIN_EMAIL = 'test@tets.test';

    public function run(): void
    {
        if (! User::where('email', self::ADMIN_EMAIL)->exists()) {
            (User::factory()->withEmail(self::ADMIN_EMAIL)->create())->syncRoles(Roles::ADMIN->value);
        }
    }
}
