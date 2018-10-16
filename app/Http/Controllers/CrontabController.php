<?php

namespace App\Http\Controllers;

use App\Models\Charts;
use App\Models\Currency;
use App\Models\DepositHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrontabController extends Controller
{
    //
    public function cron()
    {

        $time = 1511863290;
        $time_diff = time()-$time;
        $def = floor($time_diff/9);
        $this->InsertChartsData(1);   //15min
        if(($def/2 > 0) && ($def % 2 == 0)) {
            $this->InsertChartsData(2); //30min
        }
        if(($def/4 > 0) && ($def % 4 == 0)) {
            $this->InsertChartsData(4); //1h
        }
        if(($def/8 > 0) && ($def % 8 == 0)) {
            $this->InsertChartsData(8); //2h
        }
        if(($def/24 > 0) && ($def % 24 == 0)) {
            $this->InsertChartsData(24);//6h
        }
        if(($def/96 > 0) && ($def % 96 == 0)) {
            
            $this->InsertChartsData(96);//1d
        }
        if(($def/192 > 0) && ($def % 192 == 0)) {
            $this->InsertChartsData(192);//2d
        }
        if(($def/672 > 0) && ($def % 672 == 0)) {
            $this->InsertChartsData(672);//1w
        }
        if(($def/1344 > 0) && ($def % 1344 == 0)) {
            $this->InsertChartsData(1344);//2w
        }
        if(($def/2688 > 0) && ($def % 2688 == 0)) {
            $this->InsertChartsData(2688);//1Month
        }
        if(($def/5376 > 0) && ($def % 5376 == 0)) {
            $this->InsertChartsData(5376);//2Month
        }
        if(($def/16128 > 0) && ($def % 16128 == 0)) {
            $this->InsertChartsData(16128);//6Month
        }
        sleep(9);
        $this->cron();
    }

    private function InsertChartsData($gap)
    {
        $gap = isset($gap) ? intval($gap) : 1; // 1:15min 2:30min ........ 12:6month
        $end_time = time();  //待处理数据的结束时间
        $start_time = $end_time - $gap*9; //待处理数据的结束时间

      //  $sql  = sprintf("SELECT last_price,volume FROM xchange_info WHERE created_at BETWEEN $start_time AND $end_time"); //查询交易表 获取间隔时间段内 未整理的数据
        $data = DB::table('xchange_info')->select('last_price','volume')->whereBetween('created_at',[$start_time,$end_time])->get();
        //*****************超过100条删除一条***************
    //    $sql 	= sprintf("SELECT count(*) FROM charts WHERE gap = $gap");
        $result = DB::select('select count(*) as count from charts where gap = ?', [$gap]);
        //$res[0]->count;
        $count = $result[0]->count;
        if($count >= 100) {
            DB::delete("DELETE FROM charts WHERE gap = ? ORDER BY created_at ASC LIMIT 1",[$gap]);
        }elseif(($count == 0) && (count($data) == 0)) {
            return ;
        }

        //*****************超过100条删除一条***************
        if(count($data) > 0) {
            $data = $data->toArray();
            $price 	= array_column($data,'last_price');
            $volume = array_sum(array_column($data,'volume'));
            $total 	= array_sum($price);
            $length = count($price);
            if($length != 0)
                $avg 	= round($total / $length,8);
            else
                $avg 	= 0;
            $open 	= round($price[0],8);
            $colse  = round($price[$length-1],8);
            $height = round(max($price),8);
            $low 	= round(min($price),8);
            DB::table('charts')->insert(['open'=>$open,'low'=>$low,'high'=>$height,'close'=>$colse,'average'=>$avg,'gap'=>$gap,'volume'=>$volume]);
        }else{  //无数据插入之前一条最新的数据
            $res = DB::table('charts')->select('open','low','high','close','average','gap')->where('gap',$gap)->orderBy('id','desc')->first();
            DB::insert('INSERT INTO charts (open,low,high,close,average,gap) VALUES (?,?,?,?,?,?)',
                [$res->open,$res->low,$res->high,$res->close,$res->average,$res->gap]);
        }
    }

    public function get24hInfo(Request $request)
    {
        $this->validate($request,['market_id'=>'required']);
        $where = ['gap'=>192,'market_id'=>$request->market_id];
        $info = Charts::where($where)->get();
        $_24h_volume = 0;
        $_24h_change = 0;
        //TODO cache
        if (count($info)) {
            $info = $info->toArray();
            $start_price = $info[0]['average'];
            $end_price = $info[count($info)-1]['average'];
            foreach ($info as $key=>$value) {
                $_24h_volume += $value['volume'];
            }
            $diff_price = round($end_price-$start_price,2);
            $_24h_change = round($diff_price/$start_price*100,3);
        }

        $res = ['_24h_volume'=>$_24h_volume,'_24h_change'=>$_24h_change];
        return ['code'=>200,'result'=>$res];
    }

    public function getReceiveHistory()
    {
        $user = User::all();
        $currency = Currency::all();
        foreach ($currency as $coin) {
            $client = $this->getClient($coin->currency);
            foreach ($user as $u) {
                $trans_history = $client->getTransactionList($u->id);
                if($trans_history) {
                    foreach ($trans_history as $key=>$value) {
                        if($key['category'] == 'receive') {
                            $time = date('Y-m-d H:i:s',time());
                            $deposit = new DepositHistory();
                            $deposit->user_id       = $u->id;
                            $deposit->currency_id   = $coin->id;
                            $deposit->amount        = $key['amount'];
                            $deposit->address       = $key['address'];
                            $deposit->txid          = $key['txid'];
                            $deposit->timereceived  = date('Y-m-d H:i:s',$key['timereceived']);
                            $deposit->created_at    = $time;
                            $deposit->updated_at    = $time;
                            $deposit->save();
                        }
                    }
                }
            }
        }
    }
}
