<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::updateOrCreate(
            [
                'email'=>'street@gmail.com'
            ],
            [
                'email'=>'street@gmail.com',
                'password'=>Hash::make('123'),
                'mobile'=>'8867675654',
            ]
        );
    }
}
