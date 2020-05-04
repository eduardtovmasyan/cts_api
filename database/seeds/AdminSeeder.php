<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeNow = now();
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'type' => User::TYPE_ADMIN,
            'updated_at' => $timeNow,
            'created_at' => $timeNow,
        ]);
    }
}
