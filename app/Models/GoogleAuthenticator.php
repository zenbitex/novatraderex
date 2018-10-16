<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleAuthenticator extends Model
{
    //
    protected $table = 'google_authenticator';

    protected $fillable = ['user_id','google2fa_secret'];

}
