<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForgetPassword extends Model
{
    //
    protected $table = 'forget_password';
    protected $fillable = [
        'user_id','forget_token'
    ];
}
