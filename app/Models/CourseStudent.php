<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table='student_course';
    protected $fillable = [
        'student_id','course_id'
    ];

    public function students()
    {
        return $this->belongsToMany('App\Models\Student');
    }
    public function courses()
    {
        return $this->belongsToMany('App\Models\Course');
    }
}
