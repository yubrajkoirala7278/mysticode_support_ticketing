<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=User::create([
            'name'=>'Yubraj Koirala',
            'email'=>'yubrajkoirala7278@gmail.com',
            'password'=>Hash::make('123456')
        ]);
        $user->syncRoles('admin');
    }
}
