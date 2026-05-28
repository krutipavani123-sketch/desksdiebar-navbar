<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Permission::create(["name" => "create ticket", 'guard_name' => 'web']);
        // Permission::create(['name' => 'view ticket', 'guard_name' => 'web']);
        // Permission::create(["name" => "update ticket", 'guard_name' => 'web']);
        // Permission::create(['name' => 'delete ticket', 'guard_name' => 'web']);

        // $superadmin = Role::createOrFirst(['name' => 'superadmin', 'guard_name' => 'web']);
        // $admin = Role::createOrFirst(['name' => 'admin', 'guard_name' => 'web']);
        // $customer = Role::createOrFirst(['name' => 'user', 'guard_name' => 'web']);

        // $superadmin->givePermissionTo(Permission::all());

        // $customer->givePermissionTo([
        //     'view ticket'
        // ]);

        // if ($user->id == 1) {
        //     $user->assignRole('admin');
        // } else {
        //     $user->assignRole("customer");
        // }

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

