<?php

namespace App\Http\Controllers;

use App\Models\Blockchain;
use App\Models\Charts;
use App\Models\Currency;
use App\Models\Fee;
use App\Models\Market;
use App\Models\User;
use App\Models\Apikey;
use App\Models\Xchange;
use App\Models\XchangInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>'doTrade']);
    }

    public function show($market_name)
    {
        $user_id = Auth::id();
        $market_id = Market::where('market_name',$market_name)->value('id');
        if(!$market_id) {
            return redirect('trade');
        }
        $fee = Fee::where('currency_id',$market_id)->value('fee');
        $temp = round($fee*100,2);
        $fee = $temp."%";
        $currency = explode('_',$market_name);
        //TODO 记录最新的价格
        $bid = DB::select("SELECT market_id,type,last_price FROM xchange_info WHERE market_id = ? AND type = ? ORDER BY created_at DESC LIMIT 1",[$market_id,1]);
        $ask = DB::select("SELECT market_id,type,last_price FROM xchange_info WHERE market_id = ? AND type = ? ORDER BY created_at DESC LIMIT 1",[$market_id,2]);

        $nova_market = $currency[1].'_'.$currency[0];
        $rate_api = "https://novaexchange.com/remote/v2/market/info/$nova_market/";
        $res = file_get_contents($rate_api);
        $result = json_decode($res,true);

        if(empty($bid)) {
            if($result['status'] == 'success') {
                $bid = $result['markets'][0]['bid'];
            }else {
                $bid = $bid[0]->last_price;
            }
        }else {
            $bid = $bid[0]->last_price;
        }

        if(empty($ask)) {
            if($result['status'] == 'success') {
                $ask = $result['markets'][0]['ask'];
            }else {
                $ask = $bid[0]->last_price;
            }
        }else {
            $ask = $ask[0]->last_price;
        }
        //TODO ↑

        foreach ($currency as $key=>$value) {
            $client[$value] = $this->getAllClicent($value);
            if(!$client[$value]) {
                return redirect('trade');
            }
            if(!$user_id)
                $balances[$value] = 0;
            else
                $balances[$value] = $client[$value]->getBalance($user_id);
        }
        $market = Currency::where(['currency'=>$currency[0]])->orWhere(['currency'=>$currency[1]])->get();
        $another = Currency::where('currency',$currency[0])->value('full_currency');
        $history = $this->showHistory($market_id);
        return view('front.market',compact('ask','bid','balances','another','currency','market','history','market_id','fee'));
    }

    /**
     * @未完成的挂单
     * @param market_id , type (买或卖)
     * @return
     */
    public function unCompeleteOrder(Request $request)
    {

        $this->validate($request,['market_id'=>'required']);

        $where = ['market_id'=>$request->market_id,'status'=>0];
        $order = Xchange::where($where)->get();
        if (count($order)) {
            $order = $order->groupBy('type')->sortBy('price')->toArray();
            if(!empty($order[2])) {
                $order['buy'] = $order[2];
                unset($order[2]);
            }
            if(!empty($order[1])) {
                $order['sell'] = $order[1];
                unset($order[1]);
            }
        } else {
            $order = [];
        }
        return ['code'=>200,'msg'=>$order];
    }

    //TODO 独立页面的订单显示，新增订单是即时刷新对应的订单列表
    //TODO 余额即时刷新
    public function sellOrder()
    {
        
    }

    public function showHistory($market_id=null)
    {

        $data = is_null($market_id) ? [] : XchangInfo::where('market_id',$market_id)->orderBy('created_at','desc')->take(30)->get();
        return $data;
      //  return ['code'=>200,'message'=>$data];
    }

    public function doTrade(Request $request)
    {
        $this->validate($request,[
            'type'            => 'required',
            'vol'               => 'required|string',
            'price'             => 'required|numeric|min:0.00000001',
            'total'             => 'required|numeric|min:0.00000001',
            'fee'               => 'required|numeric',
            'market'            => 'required',
            'buy_net_total'     => 'required|numeric',
        ]);
        $user_id = Auth::id();
        /*$market_name = DB::table('market')
                        ->leftJoin('currency as a','from_currency','=','a.id')
                        ->leftJoin('currency as b','to_currency','=','b.id')
                        ->select('market.*','a.currency as from_currency','b.currency as to_currency')
                        ->first();*/
        $market_name = Market::where('id',$request->market)->value('market_name'); //FAL_BTC
        if(!$market_name) {
            return ['code'=>400,'message'=>'不存在的交易市场'];
        }
        // xchange 表 删除了total_btc_price字段
        //TODO 各种判断验证    market_id ,验证fee
        //获取fee
        $fee = Fee::where('currency_id',1)->value('fee');
        $fee = round($request->vol * $request->price * $fee,8);
        $currency = explode('_',$market_name);
        $buy_client = $this->getClient($currency[1]);
        $sell_client = $this->getClient($currency[0]);

        if((!$buy_client) || (!$sell_client)) {
            return ['code'=>423,'message'=>'网络问题请刷新重试'];
        }

        $company_account = 'NovaCoinMain';
        //余额判断 TODO sell 余额判断  ,密码验证或者2FA验证
        $order_id = 'Nova'.$user_id.uniqid();
        if($request->type == 'buy') {
            $total = round($request->vol * $request->price + $fee,8);
            $balances = $buy_client->getBalance($user_id);
            if($total > $balances) {
                return ['code'=>422,'message'=>'余额不足'];
            }
        }elseif($request->type == 'sell') {
            $fee_balances = $buy_client->getBalance($user_id);
            $balances     = $sell_client->getBalance($user_id);
            if($request->vol > $balances) {
                return ['code'=>422,'message'=>'余额不足'];
            }
            if($fee > $fee_balances) {
                return ['code'=>423,'message'=>'交易手续费不足'];
            }
        }else{
            return ['code'=>'424','message'=>'网络问题请刷新重试'];
        }

        DB::beginTransaction();
        try {
            if($request->type == 'buy') {
                $target_id = 'NovaCoinMain';
                BlockchainController::insertBuyOption($market_name,\Auth::id(),$target_id,$total,$order_id,2);
                $this->buy($order_id,$market_name,$request->market,$request->vol,$request->price,$request->vol,$request->fee);
                $current_blockchain_opt = Blockchain::where('order_id',$order_id)->get();
                $opt_count = count($current_blockchain_opt);
                $opt_status = 0;
                foreach ($current_blockchain_opt as $blockchain_opt) {
                    if($blockchain_opt->currency == $currency[0]) {
                        $client = $sell_client;
                    }elseif($blockchain_opt->currency == $currency[1]) {
                        $client = $buy_client;
                    }else {
                        DB::rollback();
                        return ['code'=>400];
                    }
                    $status = $client->move($blockchain_opt->user_id,$blockchain_opt->target_id,$blockchain_opt->amount);
                    if($status) {
                        $blockchain_opt->status = 1;
                        $blockchain_opt->save();
                    }
                }
                DB::commit();
                return ['code'=>200];

            } elseif ($request->type == 'sell') {
                $target_id = 'NovaCoinMain';
                BlockchainController::insertSellOption($market_name,\Auth::id(),$target_id,round($request->vol,8),$order_id,1);
                BlockchainController::insertSellFeeOption($market_name,\Auth::id(),$target_id,$fee,$order_id,1);
                $this->sell($order_id,$market_name,$request->market,$request->vol,$request->price,$request->vol,$request->fee);
                $current_blockchain_opt = Blockchain::where('order_id',$order_id)->get();
                $opt_count = count($current_blockchain_opt);
                $opt_status = 0;
                foreach ($current_blockchain_opt as $blockchain_opt) {
                    if($blockchain_opt->currency == $currency[0]) {
                        $client = $sell_client;
                    }elseif($blockchain_opt->currency == $currency[1]) {
                        $client = $buy_client;
                    }else {
                        DB::rollback();
                        return ['code'=>400];
                    }
                    $status = $client->move($blockchain_opt->user_id,$blockchain_opt->target_id,$blockchain_opt->amount);
                    if($status) {
                        $blockchain_opt->status = 1;
                        $blockchain_opt->save();
                    }
                }

                DB::commit();
                return ['code'=>200];
            } else {
                DB::rollback();
                return ['code'=>400];
            }
        } catch (Exception $e) {
            DB::rollback();
            return ['code'=>400];
        }

        return;

        $user_id = \Auth::id();
        $data = Apikey::where('user_id',$user_id)->first();
        $key = decrypt($data->key);
        $secret = decrypt($data->secret);
        $market = substr($request->get('market'),strpos($request->get('market'),'/')+1);
        $url = 'https://novaexchange.com/remote/v2/private/trade/'.$market.'/';
        $data = [
                    'tradetype'     =>  strtoupper($request->get('method')),
                    'tradeamount'   =>  $request->get('buy'),
                    'tradeprice'    =>  $request->get('price'),
                    'tradebase'     =>  (boolval('0')),
        ];
        /*dd(round($data['tradeamount'] * $data['tradeprice'],8));*/
        $result = $this->doConnectAPI($url,$key,$secret,$data);
        $result = json_decode($result,true);
        /*
         *  error:
         *  Not enough balance for the wanted trade                                 ||  余额不足
         *  Amount or price cannot be less than 0.00000001 or Non existant          ||  数量或价格不能低于0.00000001或不存在
         *  Fee must add up to 0.00000020 BTC or higher, your fee was 0.00000000    ||  费必须总计达0.00000020 BTC或更高，你的费用是0
         *  Errors in trade request, please correct                                 ||  交易请求错误，请改正
         *  ....
         *
         *
         * success:
         * "status" => "success"
            "message" => "Trade details as follows"
            "tradetype" => "BUY"
            "tradeitems" => array:1
            [
                0 => [
                "orderid" => 24401553
                "net_total" => "9979.00200000"
                "fromcurrency" => "BTC"
                "tocurrency" => "FAL"
                "price" => "0.00000002"
                "type" => "created"
                "tradefee" => "0.00000040"
                "fromamount" => "0.00019998"
                "toamount" => "9999.00000000"
                ]
            ]
            "fee_currency" => "BTC"
         *
         *
         *
         * */
        //后续在加入更精确的状态返回值
        if($result['status'] == 'error') {
            return [
                'code'      => 400,
                'message'   => $result['message']
            ];
        }else if($result['status'] == 'success') {
            return [
                'code'          =>  200,
                'orderid'       => $result['tradeitems'][0]['orderid'],
                'fromcurrency'  => $result['tradeitems'][0]['fromcurrency'],
                'tocurrency'    => $result['tradeitems'][0]['tocurrency'],
                'price'         => $result['tradeitems'][0]['price'],
                'tradefee'      => $result['tradeitems'][0]['tradefee'],
                'price'         => $result['tradeitems'][0]['price'],
                'fromamount'    => $result['tradeitems'][0]['fromamount'],
                'toamount'      => $result['tradeitems'][0]['toamount']
            ];
        }
    }


    public function getAmount(Request $request,$mark_name)
    {
        $user_id = Auth::id();
        $data = Apikey::where('user_id',$user_id)->first();
        $key = decrypt($data->key);
        $secret = decrypt($data->secret);
        $balances = $this->getbalance($key,$secret);
        $market_info_url = 'https://novaexchange.com/remote/v2/market/info/'.$mark_name.'/';
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)');
        $result = file_get_contents($market_info_url);
        $result = json_decode($result,true);
        $market_info = $result['markets'][0];
        return ['amount'=>$balances['BTC']['amount']];
    }
    //TODO 下单后先转给公司账号！！！！！！！！！！！！！！！！！！！,扣手续费操作应该在下单后马上扣 ，再看有无成交。
    private function sell($order_id,$market_name,$market_id,$vol,$price,$original_vol,$fee=0){

        $row = DB::table('xchange')->where([
                        ['status','0'],
                        ['rvolume','>',0],
                        ['type',2],
                        ['price','>=',$price]]
                )->orderBy('price','desc')->first();
        if($row){
            if($vol > $row->rvolume) {
                DB::table('xchange')->where('id',$row->id)->update(['rvolume'=>0,'status'=>1,'updated_at'=>date('Y-m-d H:i:s',time())]);
                DB::table('xchange_info')->insert(['user_id'=>\Auth::id(),'fee'=>0,'type'=>1,'market_id'=>$market_id,'last_price'=>$row->price,'volume'=>$row->rvolume,'created_at'=>time(),'updated_at'=>time()]);
                $user_id = 'NovaCoinMain';
                BlockchainController::insertSellOption($market_name,$user_id,\Auth::id(),$row->rvolume,$order_id,1);
                $vol = $vol - $row->rvolume;
                $this->sell($order_id,$market_name,$market_id,$vol,$price,$vol,$fee);
            } else {
                $rvolume = $row->rvolume - $vol;
                DB::table('xchange')->where('id',$row->id)->update(['rvolume'=>$rvolume,'updated_at'=>date('Y-m-d H:i:s',time())]);
                DB::table('xchange_info')->insert(['user_id'=>\Auth::id(),'fee'=>0,'type'=>1,'market_id'=>$market_id,'last_price'=>$row->price,'volume'=>$vol,'created_at'=>time(),'updated_at'=>time()]);
                $user_id = 'NovaCoinMain';
                BlockchainController::insertSellOption($market_name,$user_id,\Auth::id(),$row,$order_id,1);
            }
        } else {
            DB::table('xchange')->insert(['type'=>1,'market_id'=>$market_id,'user_id'=>\Auth::id(),'price'=>$price,'volume'=>$vol,'rvolume'=>$original_vol,'status'=>0,'fee'=>$fee,'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time()),'order_id'=>$order_id,'market_name'=>$market_name]);
        }
    }

    private function buy($order_id,$market_name,$market_id,$vol,$price,$original_vol,$fee=0){
        $row = DB::table('xchange')->where([
                ['status',0],
                ['rvolume','>',0],
                ['type',1],
                ['price','<=',$price]]
        )->orderBy('price','asc')->first();
        if($row){
            if($vol > $row->rvolume) { //rvolume 要买的数量大于未成交的数量
               DB::table('xchange')
                   ->where(['id'=>$row->id])
                   ->update(['rvolume'=>0,'status'=>1,'updated_at'=>date('Y-m-d H:i:s',time())]);
               $user_id = 'NovaCoinMain';
               BlockchainController::insertBuyExchangeOption($market_name,$user_id,\Auth::id(),$row->rvolume,$order_id,2);
               DB::table('xchange_info')
                    ->insert(['user_id'=>\Auth::id(),'type'=>1,'market_id'=>$market_id,'fee'=>0,'last_price'=>$row->price,'volume'=>$row->rvolume,'created_at'=>time(),'updated_at'=>time()]);
               $vol = $vol - $row->rvolume;
               $this->buy($order_id,$market_name,$market_id,$vol,$price,$vol,$fee); //还有未成交的继续买
            } else {
                $rvolume = $row->rvolume - $vol; //要买的数量小于未成交的数量
                DB::table('xchange')
                    ->where(['id'=>$row->id])
                    ->update(['rvolume'=>$rvolume,'updated_at'=>date('Y-m-d H:i:s',time())]);
                DB::table('xchange_info')
                    ->insert(['user_id'=>\Auth::id(),'type'=>2,'market_id'=>$market_id,'fee'=>0,'last_price'=>$row->price,'volume'=>$vol,'created_at'=>time(),'updated_at'=>time()]);
                $user_id = 'NovaCoinMain';
                BlockchainController::insertBuyExchangeOption($market_name,$user_id,\Auth::id(),$vol,$order_id,2);
            }
        } else {
            DB::table('xchange')->insert(['type'=>2,'market_id'=>$market_id,'user_id'=>\Auth::id(),'price'=>$price,'volume'=>$vol,'rvolume'=>$original_vol,'status'=>0,'fee'=>$fee,'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time()),'order_id'=>$order_id,'market_name'=>$market_name]);
        }
    }

    public function getApiData(Request $request)
    {
        $this->validate($request,['stamp'=>'required','market_id'=>'required']);
        $gap = $request->stamp ? $request->stamp : 1;
        $num = 100;
        $res = Charts::where('gap',$gap)->where('market_id',$request->market_id)->orderBy('id','asc')->take($num)->get()->toArray();
        return $res;
        return ['code'=>200,'result'=>$res];
    }

    public function testa()
    {
        //添加公司账号
        $company = 'NovaCoinMain';
        $btc_client = $this->getBTCClient();
        $ltc_client = $this->getLTCClient();
        $brc_address = $btc_client->getAddressList($company);
        $ltc_address = $ltc_client->getAddressList($company);
        echo "<pre>";
        print_r($brc_address);
        echo "<br/>";
        print_r($ltc_address);
    }

    public function getBalacesByUser()
    {
        $btc = $this->getBTCClient();
        $fal = $this->getFALClient();
        $user = User::all();
        $balance = [];
        $user = 1;
        $result =$btc->getTransactionList($user);
        if($result) {
            foreach ($result as $key=>$value) {
                if($key['category'] == 'receive') {
                    print_r($result[$key]);
                }
            }
        }
        dd(1);
        //$btc->move('NovaCoinMain',1,0.09863698);
        foreach ($user as $u) {
            $balance[$u->id]['btc'] = $btc->getBalance($u->id);
            $balance[$u->id]['fal'] = $fal->getBalance($u->id);
        }
        $balance['Main']['btc'] = $btc->getBalance('NovaCoinMain');
        $balance['Main']['fal'] = $fal->getBalance('NovaCoinMain');
        foreach ($balance as $key=>$value) {
            foreach ($value as $kk=>$vv) {
                if(strpos($balance[$key][$kk],'e') !== false)
                    $balance[$key][$kk] = $this->sctonum($vv);
            }
        }
        dd($balance);
    }

    function sctonum($num, $double = 8){
        if(false !== stripos($num, "e")){
            $a = explode("e",strtolower($num));
            return bcmul($a[0], bcpow(10, $a[1], $double), $double);
        }
    }

}
