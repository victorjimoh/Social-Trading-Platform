<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class FriendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'John John  ',
            'email' => 'doejohn@gmail.com',
            'username' => '1234567890',
            'password' => '12345678910',
            
        ]);


        
    }
}
