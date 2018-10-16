<?php

namespace App\Http\Controllers;

use App\Models\Xchange;
use App\Policies\OrderPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Apikey;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>[]]);
    }

    //TODO 修改为API

    public function myopenorders()
    {
        $where = ['user_id'=>\Auth::id(),'status'=>0];
        $open_order = DB::table('xchange')
                        ->leftjoin('market as m','market_id','=','m.id')
                        ->select('xchange.*','m.market_name')
                        ->where($where)
                        ->get();

        return view('front.openorders',compact('open_order'));
    }


    public function cancel(Request $request)
    {
        $this->validate($request,[
            'pin'          => 'required|min:6',
            'orderid'      => 'required|integer',
        ]);
        $user_id = \Auth::id();
        $user_info = User::where('id',$user_id)->select('password','secpass')->first();
        if(empty($user_info->secpass)) {
            return ['code'=>403,'message'=>'No pin'];
        }
        if(Hash::check($request->get('pin'),$user_info->secpass)){
            $xchange = Xchange::where('id',$request->orderid)->first();
            $this->authorize('cancel', $xchange);
            $xchange->delete();
            return ['code'=>200,'message'=>'success'];
        }else{
            return ['code'=>400,'message'=>'pin error'];
        }
    }

    public function history()
    {
        $where = ['user_id'=>\Auth::id()];
        $history = DB::table('xchange_info')
            ->leftjoin('market as m','market_id','=','m.id')
            ->select('xchange_info.*','m.market_name')
            ->where($where)
            ->get();
        //dd($history);
        //dd($history);
        return view('front.orderhistory',compact('history'));

    }

}
