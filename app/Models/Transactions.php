<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'date','student_id','order_no','coupon_id','remark','payment_mode','subtotal','tax','total','discount','status'
    ];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
