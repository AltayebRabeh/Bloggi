<?php

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'System Administrator',
            'allowed_route' => 'admin',
            ]);

        $editorRole = Role::create([
            'name' => 'editor',
            'display_name' => 'Supervisor',
            'description' => 'System Supervisor',
            'allowed_route' => 'admin',
            ]);

        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'Normal User',
            'allowed_route' => null,
            ]);


        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@bloggi.test',
            'mobile' => '0127400216',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('123123123'),
            'status' => 1,
        ]);

        $admin->attachRole($adminRole);

        $editor = User::create([
            'name' => 'Editor',
            'username' => 'editor',
            'email' => 'editor@bloggi.test',
            'mobile' => '0912365686',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('123123123'),
            'status' => 1,
        ]);

        $editor->attachRole($editorRole);

        $user1 = User::create(['name' => 'Altayeb Fadlelmola','username' => 'altayeb','email' => 'altayeb@bloggi.test','mobile' => '0929161131','email_verified_at' => Carbon::now(),'password' => bcrypt('123123123'),'status' => 1,]);
        $user1->attachRole($userRole);

        $user2 = User::create(['name' => 'Mazen Saif','username' => 'mazen','email' => 'mazen@bloggi.test','mobile' => '0127400218','email_verified_at' => Carbon::now(),'password' => bcrypt('123123123'),'status' => 1,]);
        $user2->attachRole($userRole);

        $user3 = User::create(['name' => 'Atif Saif','username' => 'atif','email' => 'atif@bloggi.test','mobile' => '0912384646','email_verified_at' => Carbon::now(),'password' => bcrypt('123123123'),'status' => 1,]);
        $user3->attachRole($userRole);

        for ($i=0; $i < 10 ; $i++) { 
            $user = User::create(['name' => $faker->name ,'username' => $faker->username,'email' => $faker->email,'mobile' => '00249' . random_int(100000000, 999999999),'email_verified_at' => Carbon::now(),'password' => bcrypt('123123123'),'status' => 1,]);
            $user->attachRole($userRole);
        }
    }
}
