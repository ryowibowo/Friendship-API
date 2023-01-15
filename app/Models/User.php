<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function sendRequestFriend()
    {
        return $this->hasMany(Friend::class, 'user_id_1', 'id');
    }

    public function receivedRequestFriend()
    {
        return $this->hasMany(Friend::class, 'user_id_2', 'id');
    }

    public function friends(){
        return $this->belongsToMany(User::class, 'friends', 'user_id_1', 'user_id_2');
       }

}
