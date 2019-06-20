<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'username'  => 'admin',
            'email' => 'admin@admin.com',
            'password'  => bcrypt('admin123'),
        ]);
    }
}
