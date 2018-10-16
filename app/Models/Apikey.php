<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apikey extends Model
{
    //
    protected $fillable = ['user_id','key','secret'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
