<?php

    use App\Models\BackpackUser as User;
    // use App\User;
    use Backpack\PermissionManager\app\Models\Role;
    use Illuminate\Database\Seeder;
    use Spatie\Permission\Models\Permission;

    class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('12345678'),
            'remember_token' => null
        ]);

        $role = Role::create(['name' => '管理員', 'guard_name' => 'web']);
        Role::create(['name' => '教師', 'guard_name' => 'web']);
        Role::create(['name' => '學生', 'guard_name' => 'web']);

        $permission = Permission::create(['name' => '後台管理', 'guard_name' => 'web']);

        $role->givePermissionTo($permission);
        $user->assignRole($role);
    }
}
