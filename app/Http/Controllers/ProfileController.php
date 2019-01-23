<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\StoreProfileUsers;
use App\Profile;
use App\Role;
use App\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with('role','profile')->latest()->paginate(6);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $countries = Country::all();
        $states = State::all();
        return view('admin.users.add', compact('roles','countries','states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // defaut image path for userif user does not upload photo
       $nouserpic = "nouser.png";


       // manipulating img
                
    if ($request->has('thumbnail')) {
            
            $current_date = Carbon::now()->toDateString();
            $file_name = $current_date.uniqid().$request->file('thumbnail')->getClientOriginalName();
            // if  dir not exist
            if (!Storage::disk('public')->exists('users') ) {
            // then make tthe dir
            Storage::disk('public')->makeDirectory('users');
            }
            
            // if dirr eexist
            if (Storage::disk('public')->exists('products') ) {

            // resize the image
            $user_image = Image::make($request->thumbnail)->resize(300, 200)->save();

            // now save the image;
            Storage::disk('public')->put('users/'.$file_name, $user_image);
                      $request->thumbnail= $file_name;
            }

       // insert user    with image  
        $user = User::create([
            "email" => $request->email,
            "role_id" => $request->role_id,
            "status" => $request->status,
            "password" => bcrypt($request->password),
        ]);

         if ($user) {
               // create a user profile after register  user
               $profile = Profile::create([
                    "user_id" => $user->id,
                    "name" => $request->name,
                    "address" => $request->address,
                    "contact" => $request->phone,
                    "slug" => str_slug($request->name, '-'),
                    "thumbnail" => $file_name,
                    "contact" => $request->phone,
                    "country_id" => $request->country_id,
                    "state_id" => $request->state_id,
                    "city_id" => $request->city_id,
               ]);       
        }


      }
  
    else {

       // insert user    with out img    
        $user = User::create([
            "email" => $request->email,
            "role_id" => $request->role_id,
            "status" => $request->status,
            "password" => bcrypt($request->password)
        ]);

        if ($user) {
               // create a user profile after register  user
               $profile = Profile::create([
                    "user_id" => $user->id,
                    "name" => $request->name,
                    "address" => $request->address,
                    "contact" => $request->phone,
                    "slug" => str_slug($request->name, '-'),
                    "thumbnail" => $nouserpic,
                    "contact" => $request->phone,
                    "country_id" => $request->country_id,
                    "state_id" => $request->state_id,
                    "city_id" => $request->city_id,
               ]);       
        }
    


      }


             // after rediirection
            if ($user && $profile) {
                return redirect(route('admin.profile.index'))->with('message','user added');
            } else {
                return back()->with('message','reuest failed');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function getStates(Request $request ,$id) 
    {
        if ( $request->ajax() ) {
            return State::where('country_id',$id)->get();
        } else {
            return 'NOT_AJAX_REQUEST';
        }
    }

    public function getCities(Request $request,$id)
    {
       if ( $request->ajax() ) {
            return City::where('state_id',$id)->get();
        } else {
            return 'NOT_AJAX_REQUEST';
        }   
    }
}
