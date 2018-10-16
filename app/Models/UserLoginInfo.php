<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLoginInfo extends Model
{
    //
    protected $table = 'user_login_info';
    protected $fillable = ['user_id','login_ip','last_login_ip','login_time','last_login_time'];
    public $timestamps = false;


}
