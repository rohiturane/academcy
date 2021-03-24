<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTransactions extends Model
{
    protected $fillable = [
        'course_id', 'transaction_id', 'amount'
    ];

    public function courses()
    {
        return $this->belongsToMany('App\Models\Course');
    }

    public function transactions()
    {
        return $this->belongsToMany('App\Models\Transaction');
    }
}
