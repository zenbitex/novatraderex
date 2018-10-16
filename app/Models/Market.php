<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    //
    protected $table = 'market';

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency','id','from_currency');
    }
}
