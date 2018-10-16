<?php

namespace App\Http\Controllers;

use App\Models\Blockchain;
use Illuminate\Http\Request;

class BlockchainController extends Controller
{
    //
    public function move($client,$user_id,$target_id,$amount,$order_id)
    {
        $move_status = $client->move($user_id,$target_id,$amount);
        if($move_status) {
            //id , coin , user_id , target_id ,amount status ,created_at ,updated_at ,order_id
        }
    }


    public static function insertBuyOption($market_name,$user_id,$target_id,$amount,$order_id,$type=2)
    {
        $currency = explode('_',$market_name);
        $coin = $currency[1];
        $blockchain_opt = new Blockchain();

        $blockchain_opt->order_id = $order_id;
        $blockchain_opt->currency = $coin;
        $blockchain_opt->user_id = $user_id;
        $blockchain_opt->target_id = $target_id;
        $blockchain_opt->amount = $amount;
        $blockchain_opt->status = 0;
        $blockchain_opt->type = 2;
        $blockchain_opt->save();

        //TODO 是否需要记录涉及的区块链操作次数
    }

    public static function insertBuyExchangeOption($market_name,$user_id,$target_id,$amount,$order_id,$type=2)
    {
        $currency = explode('_',$market_name);
        $coin = $currency[0];
        $blockchain_opt = new Blockchain();

        $blockchain_opt->order_id   = $order_id;
        $blockchain_opt->currency   = $coin;
        $blockchain_opt->user_id    = $user_id;
        $blockchain_opt->target_id  = $target_id;
        $blockchain_opt->amount     = $amount;
        $blockchain_opt->status     = 0;
        $blockchain_opt->type       = 2;
        $blockchain_opt->save();
    }

    public static function insertSellOption($market_name,$user_id,$target_id,$amount,$order_id,$type=1)
    {
        $currency = explode('_',$market_name);
        $coin = $currency[0];
        $blockchain_opt = new Blockchain();

        $blockchain_opt->order_id = $order_id;
        $blockchain_opt->currency = $coin;
        $blockchain_opt->user_id = $user_id;
        $blockchain_opt->target_id = $target_id;
        $blockchain_opt->amount = $amount;
        $blockchain_opt->status = 0;
        $blockchain_opt->type = 1;
        $blockchain_opt->save();
    }

    public static function insertSellFeeOption($market_name,$user_id,$target_id,$amount,$order_id,$type=1)
    {
        $currency = explode('_',$market_name);
        $coin = $currency[1];
        $blockchain_opt = new Blockchain();

        $blockchain_opt->order_id = $order_id;
        $blockchain_opt->currency = $coin;
        $blockchain_opt->user_id = $user_id;
        $blockchain_opt->target_id = $target_id;
        $blockchain_opt->amount = $amount;
        $blockchain_opt->status = 0;
        $blockchain_opt->type = 1;
        $blockchain_opt->fee_or_trade = 0;
        $blockchain_opt->save();
    }

    //TODO 合并以上操作

    public static function doBlockchainOpt($order_id)
    {

    }
}
