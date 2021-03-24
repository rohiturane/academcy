<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $fillable = [
        'name','description','discount_type','status','code','start_date','end_date','amount'
    ];
}
