<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name','status','uuid','description','amount','discount','course_type',
    ];

    public function video()
    {
        return $this->hasMany('App\Models\Video');
    }
}
