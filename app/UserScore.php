<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserScore extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'id_users', 'id_soals', 'score', 'created_at', 'updated_at'
    ];
}
