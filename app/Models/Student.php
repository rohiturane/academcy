<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name','middle_name','last_name','uuid','email','mobile','status','video_seen','isLogged'
    ];
    protected $casts = [
        'video_seen' => 'array'
        ];
}
