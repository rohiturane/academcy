<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'course_id','title','description','youtube_link','status'
    ];
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
