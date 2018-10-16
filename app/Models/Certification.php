<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    //
    protected $fillable = [
        'user_id','region','phone','fullname','address','birth','photo','identity'
    ];
}
