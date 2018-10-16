<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Apikey;
use App\Models\User;

class DepositController extends Controller
{
    //
    public function getDepositHistory(Request $request)
    {
        $user_id = Auth::id();
        return view('front.deposithistory',compact('deposits'));
    }
}
