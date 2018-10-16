<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Market;
use App\Models\User;
use App\Models\Apikey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TradeController extends Controller
{
    //
    public function index()
    {
        $user_id = \Auth::id();
        //获取可供交易的货币列表和市场列表
        $market  = DB::table('market')
                    ->leftJoin('currency as a','market.from_currency','=','a.id')
                    ->leftJoin('currency as b','market.to_currency','=','b.id')
                    ->select('market.market_name','b.currency as base_currency',
                        'b.full_currency as base_full_currency','a.currency as to_currency','a.full_currency as to_full_currency')
                    ->get();
        $market = $market->groupBy('to_currency');
        //dd($market);
        return view('front.trade',compact('market'));
    }
}
