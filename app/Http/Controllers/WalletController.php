<?php

namespace App\Http\Controllers;
use App\Models\Xchange;
use App\Models\XchangInfo;
use Google;
use App\Models\Apikey;
use App\Models\User;
use App\Models\Currency;
use App\Models\User2faInfo;
use Illuminate\Http\Request;
use App\Models\GoogleAuthenticator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Authy;
use Authy\AuthyApi as AuthyApi;
use Mockery\Exception;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>[]]);
    }

    //
    public function index()
    {
        $user_id = Auth::id();
        $currency_list = Currency::select('currency','full_currency')->get();
        $where = ['user_id'=>$user_id,'status'=>0];
        $trade_balance = Xchange::where($where)->select('market_id','type','rvolume','price','market_name')->get();
        $client  = [];
        $address = [];
        $balance = [];
        $trade   = [];
        //TODO整理合并foreach
        foreach ($currency_list as $key=>$value) {
            $client[$value->currency] = $this->getAllClicent($value->currency);
            $trade[$value->currency]  = 0;
        }
        if($trade_balance) {
            foreach ($trade_balance as $tra) {
                $market_array = explode('_',$tra->market_name);
                $currency = $market_array[0];
                $basic_currency = $market_array[1];
                $price = round($tra->rvolume*$tra->price,8);
                if($tra->type == 1) {
                    $trade[$currency] += $price;
                }elseif($tra->type == 2) {
                    $trade[$basic_currency] += $price;
                }
            }
        }
        foreach ($currency_list as $key=>$value) {
            $address[$value->currency] = $client[$value->currency]->getAddressList($user_id);
            if(empty($address[$value->currency])) {
                $client[$value->currency]->getNewAddress($user_id);
            }
            $balance[$value->currency]['balance'] = $client[$value->currency]->getBalance($user_id);
            $balance[$value->currency]['currency'] = $value->currency;
            $balance[$value->currency]['full_currency'] = $value->full_currency;
            $balance[$value->currency]['trade'] = $trade[$value->currency];
        }
        $_2fa_info = $this->get2FA($user_id);
        $where = ['user_id'=>$user_id,'status'=>0];
        return view('front.index',compact('balance','_2fa_info'));
    }

    public function getaddress(Request $request)
    {
        $this->validate($request,[
            'currency'=>'required|string'
        ]);
        $client = null;
        //TODO 根据数据库添加的货币列表来获取对应的RPC客户端和地址
        switch ($request->currency) {
            case 'BTC':
                $client = $this->getBTCClient();
                break;
            case 'LTC':
                $client = $this->getLTCClient();
                break;
            case 'FAL':
                $client = $this->getFALClient();
                break;
            case 'BTG':
                $client = $this->getBTGClient();
                break;
            case 'BCH':
                $client = $this->getBCHClient();
                break;
        }
        if (!$client)
            return ['code'=>400];
        $user_id = Auth::id();
        $address = $client->getAddress($user_id);
        return response()->json(['code'=>200,'address'=>$address]);
    }

    public function getTxFee(Request $request)
    {
        $this->validate($request,[
            'currency' => 'required|string|exists:currency,currency',
        ]);
        $fee = Currency::where('currency',$request->currency)->first()->fee;
        $fee = is_object($fee) ? $fee->fee : 0;
        return ['code'=>200,'message'=>$fee];
    }

    private function get2FA($user_id)
    {
        $user_2fa_info = User2faInfo::where('user_id',$user_id)->pluck('2fa_type');
        return $user_2fa_info->all();
    }

    //2FA验证
    public function check2FA($user_id,$_2fa_type,$code)
    {
        $where = ['user_id'=>$user_id,'2fa_type'=>$_2fa_type];
        $info = User2faInfo::where($where)->first();
        if(!$info)
            return false;
        if($_2fa_type == 1) {
            //TODO authy_id 加密
            $authyApi = new \Authy\AuthyApi(env('AUTHY_API_KEY'));
            $authyId = Authy::where('user_id',$user_id)->value('authy_id');
            $verification = $authyApi->verifyToken($authyId, $code);
            if($verification->ok()){
                return true;
            }else{
                return false;
            }
        }elseif ($_2fa_type == 2) {

        }elseif ($_2fa_type == 3) {
            $google = decrypt(GoogleAuthenticator::where('user_id',$user_id)->value('google2fa_secret'));
            if(Google::CheckCode($google['google2fa_secret'],$code)) {
                return true;
            }else{
                return false;
            }
        }
    }

    public function testa()
    {
        $user_id = 1;
        $code = $_GET['code'];
        $authyApi = new \Authy\AuthyApi(env('AUTHY_API_KEY'));
        $authyId = Authy::where('user_id',$user_id)->value('authy_id');
        $verification = $authyApi->verifyToken($authyId, $code);
        if($verification->ok()){
            dd(1);
        }else{
            dd(2);
        }
    }

    public function mywithdrawhistory()
    {
        //Withdrawal history
        //URL: /remote/v2/private/getwithdrawalhistory/
        $url = 'https://novaexchange.com/remote/v2/private/getwithdrawalhistory/';
        $user_id = Auth::id();
        $data = Apikey::where('user_id',$user_id)->get()->toArray();
        $key = decrypt($data[0]['key']);
        $secret = decrypt($data[0]['secret']);
        $response = $this->doConnectAPI($url,$key,$secret);
        $result = json_decode($response,true);
        if($result['status'] == 'success') {
            $allhistory = $result['items'];
            return view('front.withdrawhistory',compact('allhistory'));
        }else{
            return view('front.withdrawhistory');
        }

    }

    public function doWithdraw(Request $request)
    {
        $this->validate($request,[
            'address'   => 'required|string|min:30',
            'amount'    => 'required|size:0.00000001',
            'pin'       => 'required',
            'currency'  => 'required|exists:currency,currency',
        ]);
        $user_id = Auth::id();
        $client = $this->getClient($request->currency);
        if(!$client)
            return ['code'=>400];
        // 获取余额验证余额
        $current_balance = $client->getBalance($user_id);
        $fee = Currency::where('currency',$request->currency)->first()->fee;
        $fee = is_object($fee) ? $fee->fee : 0;
        if($request->amount > ($current_balance + $fee)) {
            return ['code'=>401,'message'=>'balance is not enough'];
        }
        // 校验pin码
        $user_info = User::where('id',$user_id)->select('secpass')->first();
        if (!Hash::check($request->pin, $user_info->secpass)) {
            return ['code'=>402,'message'=>'pin error'];
        }
        // 检验2fa

        $withdraw_url   = 'https://novaexchange.com/remote/v2/private/withdraw/'.$request->get('currency').'/';
        $balance_url    = 'https://novaexchange.com/remote/v2/private/getbalance/'.$request->get('currency').'/';
        $fee_url        = 'https://novaexchange.com/remote/v2/private/walletstatus/'.$request->get('currency').'/';;
        //转账费不明确是否改变，先获取API.. 是否需要获取.
        /*$fee_result = $this->doConnectAPI($fee_url,$key,$secret);
        if($fee_result['status'] == 'success') {
            $tx_fee = $fee_result['coininfo']['tx_fee'];
        }else{
            return ['code'=>400,'message'=>'获取交易费率失败'];
        }
        //是否需要判断余额？
        $balance_result = $this->doConnectAPI($balance_url,$key,$secret);
        $balance_result = json_decode($balance_url,true);
        if($balance_result['status'] == 'success') {
            if($request->get('amount') > ($balance_result['balances']['amount'] + $tx_fee)) { //remote/v2/private/walletstatus/
                return ['code'=>402,'message'=>'余额不足'];
            }
        }else{
            return ['code'=>400,'message'=>'获取余额失败'];
        }*/
        $user = User::where('id',Auth::id())->select('id','secpass')->first();
        if(Hash::check($request->get('pin'), $user->secpass)) {
            $params = [
                'currency'  => $request->get('currency'),
                'amount'    => $request->get('amount'),
                'address'   => $request->get('address'),
            ];
            $result = $this->doConnectAPI($withdraw_url,$key,$secret,$params);
            $result = json_decode($result,true);
            if(strpos($result['status'],'success')!==false) {
                return ['code'=>200,'message'=>$result['message']];
            }elseif(strpos($result['message'],'Maximum allowed')!==false){
                return ['code'=>400,'message'=>'Maximum allowed'];
            }
        }else{
            return ['code'=>403];
        }

    }


    public function test()
    {
        //$url = 'https://novaexchange.com/remote/v2/private/getbalances/';getdepositaddress
        //$this->doConnectAPI();
        $user_id = Auth::id();
        $data = Apikey::where('user_id',$user_id)->get()->toArray();
        $key = decrypt($data[0]['key']);
        $secret = decrypt($data[0]['secret']);
        $url = 'https://novaexchange.com/remote/v2/private/walletstatus/NPOINT/';  ///remote/v2/private/walletstatus/BTC/
        $result = $this->doConnectAPI($url,$key,$secret);
        $result = json_decode($result,true);
        echo '<pre>';
        if($result['status'] == 'success') {
          /*  $arr = array_column( $result['coininfo'] ,'currency');
            $index = array_search('NPOINT',$arr);*/
            $tx_fee = $result['coininfo']['tx_fee'];
        }

        //$result = $result['coininfo'];

      /*  $arr = array_column($result,'currency');
        print_r($arr);*/
    }
}
