<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => 'Admin User',
            'username'  => 'admin',
            'email' => 'admin@admin.com',
            'password'  => bcrypt('admin123'),
        ]);

        Model::reguard();
    }
}
