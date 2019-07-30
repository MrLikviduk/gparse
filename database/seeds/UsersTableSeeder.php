<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => config('auth.admin.email'),
            'password' => Hash::make(config('auth.admin.password'))
        ]);
        $user->assignRole('admin', 'user');
    }
}
