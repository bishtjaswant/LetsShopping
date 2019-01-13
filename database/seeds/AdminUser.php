<?php

use App\Profile;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	// crreate  a role
        $role = Role::create([
             'name'=> 'customer',
             'description'=> 'itt is customer'
        ]);


        $role = Role::create([
             'name'=> 'admin',
             'description'=> 'itt is admin'
        ]);


        // create a user

          $user = User::create([
             'email' => 'admin@gmail.com',
             'password' => bcrypt('secret'),
             'role_id'=> $role->id,
        ]);



          $profile = Profile::create([
             'user_id'=> $user->id,
        ]);







    }
}
