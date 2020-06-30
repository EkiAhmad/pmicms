<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::beginTransaction();
        $user = User::create([
            'user_username' => 'admindoni',
            'password' => Hash::make('123456')
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $permission = [
            'role-create',
            'role-delete',
            'role-update',
            'role-list'
        ];
        foreach ($permission as $key => $value) {
            $create_permission = Permission::create(['name' => $value]);
            DB::insert('insert into role_has_permissions (permission_id, role_id) values (?, ?)', [$create_permission->id, $role->id]);
        }
        DB::commit();
    }
}
