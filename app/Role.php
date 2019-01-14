<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes;
    protected $guarded =  [];
    
    protected $dates = ['deleted_at'];
    
    public function users()
    {
        return $this->hasMany('App\User');  // a role mayy assigned to many user	
    }



}
