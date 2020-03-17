<?php

use App\Permission;
use App\User;
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
        $permissions = Permission::all();
        $admin = User::updateOrCreate(
            [
                'email' => 'admin@example.com',
            ],
            [
                'name' => 'admin',
                'password' => bcrypt(config('app.admin_password')),
            ]);
        $admin->permission()->sync($permissions->pluck('id'));
    }
}
