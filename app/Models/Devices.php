<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    protected $table = 'devices';
    protected $fillable = [
        'user_id','user_agent','ip_address'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
