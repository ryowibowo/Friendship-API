<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id_1', 'user_id_2','status'
    ];

    public function userRequest()
    {
        return $this->belongsTo(User::class, 'user_id_1');
    }

    public function userReceived()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }

}

