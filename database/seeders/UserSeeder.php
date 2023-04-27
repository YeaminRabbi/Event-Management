<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $super_admin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        //creating a super admin
        $SuperUser = new User;
        $SuperUser->name = 'Super Admin';
        $SuperUser->email = 'super@gmail.com';
        $SuperUser->password =  Hash::make('123');
        $SuperUser->pass =  '123';
        $SuperUser->phone =  '01777777771';
        $SuperUser->gender =  'male';
        $SuperUser->save();

        //creating an admin
        $AdminUser = new User;
        $AdminUser->name = 'Admin';
        $AdminUser->email = 'admin@gmail.com';
        $AdminUser->password =  Hash::make('123');
        $AdminUser->pass =  '123';
        $AdminUser->phone =  '01777777772';
        $AdminUser->gender =  'male';
        $AdminUser->save();

        //creating an user
        $User = new User;
        $User->name = 'User';
        $User->email = 'user@gmail.com';
        $User->password =  Hash::make('123');
        $User->pass =  '123';
        $User->phone =  '01777777773';
        $User->gender =  'male';
        $User->save();

        // Assign role to user
        $User->assignRole($user);
        $SuperUser->assignRole($super_admin);
        $AdminUser->assignRole($admin);
    }
}
