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
        $customer_role = Role::create([
             'name'=> 'customer',
             'description'=> 'it is customer'
        ]);


        $retailer_role = Role::create([
             'name'=> 'retailer',
             'description'=> 'it is retailer'
        ]);

         
        $admin_role = Role::create([
             'name'=> 'admin',
             'description'=> 'it is admin'
        ]);


        // create a admin user
          $admin_user = User::create([
             'email' => 'admin@gmail.com',
             'password' => bcrypt('secret'),
             'role_id'=> $admin_role->id,
        ]);

   // create a user
          $user = User::create([
             'email' => 'jaswant@gmail.com',
             'password' => bcrypt('secret'),
             'role_id'=> $customer_role->id,
        ]);



          $profile = Profile::create([
             'user_id'=> $user->id,
        ]);







    }
}
