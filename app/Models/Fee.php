<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    //
    protected $table = 'fee';

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }
}
