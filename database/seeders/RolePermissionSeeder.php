<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Foster;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // permissions
        // pets
        Permission::create(['name' => 'view trashed pets']);
        Permission::create(['name' => 'manage pets']);
        Permission::create(['name' => 'delete pets']);
        Permission::create(['name' => 'view pets']);

        Permission::create(['name' => 'view trashed fosters']);
        Permission::create(['name' => 'manage fosters']);
        Permission::create(['name' => 'delete fosters']);
        Permission::create(['name' => 'view fosters']);

        Permission::create(['name' => 'view trashed users']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view users']);

        Permission::create(['name' => 'view trashed wheels']);
        Permission::create(['name' => 'manage wheels']);
        Permission::create(['name' => 'delete wheels']);
        Permission::create(['name' => 'view wheels']);

        // roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        $foster = Role::create(['name' => 'foster']);

        // assign permissions
        $superAdmin->givePermissionTo(Permission::all());

        $user = User::updateOrCreate(
            ['email' => 'aries.alteon@gmail.com'],
            [
                'name' => 'Sadmin',
                'password' => Hash::make('arizanda'),
            ]
        );

        $user->assignRole($superAdmin);

        $admin->givePermissionTo([
            'manage pets',
            'delete pets',
            'view pets',
            'manage fosters',
            'delete fosters',
            'view fosters',
            'manage wheels',
            'delete wheels',
            'view wheels',
        ]);

        $user_admin = User::updateOrCreate(
            ['email' => 'nikki@coastalbendweb.com'],
            [
                'name' => 'Nikki',
                'password' => Hash::make('25kL7Z+kRm?M'),
            ]
        );

        $user_admin->assignRole($admin);

        $foster->givePermissionTo([
            'view pets',
        ]);

        $user_foster = User::updateOrCreate(
            ['email' => 'foster@gmail.com'],
            [
                'name' => 'foster',
                'password' => Hash::make('arizanda'),
            ]
        );

        $user_admin->assignRole($foster);
        $user_foster->assignRole($foster);

        Foster::create([
            'user_id' => 2,
            'foster_image' => 'fosters/default.png',
            'phone' => '012345689',
            'address' => 'Test address',
            'status' => 'Approved',
            'description' => 'Test foster',
        ]);

        Foster::create([
            'user_id' => 3,
            'foster_image' => 'fosters/default.png',
            'phone' => '9876543210',
            'address' => 'Test address 2',
            'status' => 'Pending',
            'description' => 'Test foster',
        ]);
    }
}
