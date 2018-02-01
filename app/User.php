<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'dob', 'email', 'password', 'mobile_number', 'registration_token', 'role', 'is_verified', 'about_me', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->role;
    }


    public function userReviews(){
        return $this->HasMany('App\PropertyReviews','rating_to_user','id');//->select(array('rating_to_user','rating', 'reason_for_rating', 'comments'));
    }
    
      public function getReminderEmail(){
        return $this->email;
    }

    public function getRememberToken(){
        return $this->remember_token;
    }

    public function setRememberToken($value){
        $this->remember_token = $value;
    }

    public function getRememberTokenName(){
        return 'remember_token';
    }
}
