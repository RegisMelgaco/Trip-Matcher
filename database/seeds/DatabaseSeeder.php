<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Regis',
            'email' => 'regis@gmail.com',
            'password' => bcrypt('16061606')
        ]);
    }
}
