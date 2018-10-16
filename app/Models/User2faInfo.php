<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User2faInfo extends Model
{

    protected $table = 'user_2fa_info';
    protected $fillable = ['user_id','2fa_type'];

}
