<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=new \App\Models\User();
        $user->email='admin@admin.com';
        $user->name='admin';
        $user->password=bcrypt('admin@123');
        $role=-1;
        $user->phone="9800000000";
        $user->save();
    }
}
