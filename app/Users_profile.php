<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_profile extends Model
{
    protected $table="profile";

        protected $fillable=[
        	'name',
        	'email',
            'type',
            'phone',
            'password',
            'status', 
           
        ];
}
