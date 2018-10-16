<?php

namespace App\Http\Controllers;
use App\Handlers\Client;
use App\Handlers\jsonRPCClient;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function doConnectAPI($url,$key,$secret,$req=null)
    {
        $url = $url.'?nonce='.strtotime(date('Y-m-d'));
        $hmac = base64_encode( hash_hmac ( 'sha512' , $url , $secret, true) );
        $req['apikey']    = $key;
        $req['signature'] = $hmac;
        // $req['currency'] = 'FAL';
        // $req['amount'] = '2';
        // $req['address'] = 'TSKddPEch5PFtEYuyWQ4xEv75UTxh5h2kF';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($req));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);// 这个是主要参数
        $response = curl_exec($curl);
        curl_close($curl);
        //var_dump($response);
        return $response;
    }

    protected function getbalance($key,$serect)
    {
        $data = ['BTC'=>[],'FAL'=>[],'ETH'=>[]];
        $url = 'https://novaexchange.com/remote/v2/private/getbalances/';
        $response = $this->doConnectAPI($url,$key,$serect);
        $result = json_decode($response,true);
        if($result['status'] == 'success') {
            $balances = $result['balances'];
            foreach ($balances as $key => $value) {
                if(($value['amount'] > 0) || (array_key_exists ($value['currency'], $data))) {
                    $data[$value['currency']]['currencyid'] 		= $value['currencyid'];
                    $data[$value['currency']]['currency'] 		 	= $value['currency'];
                    $data[$value['currency']]['amount']				= $value['amount'];
                    $data[$value['currency']]['amount_trades'] 		= $value['amount_trades'];
                    $data[$value['currency']]['amount_total'] 		= $value['amount_total'];
                    $data[$value['currency']]['currencyname'] 		= $value['currencyname'];
                    $data[$value['currency']]['amount_lockbox'] 	= $value['amount_lockbox'];
                }
            }
        }
        return $data;
    }

    protected function getBTCClient()
    {
        $btc_client = new Client(getenv('BTC_HOST'),getenv('BTC_PORT'),getenv('BTC_USER'),getenv('BTC_PASS'),'BTC');
        return  $btc_client;
    }

    protected function getDOGClient()
    {
        $dog_client = new Client(getenv('DOG_HOST'),getenv('DOG_PORT'),getenv('DOG_USER'),getenv('DOG_PASS'),'DOG');
        return $dog_client;
    }

    protected function getLTCClient()
    {
        $ltc_client = new Client(getenv('LTC_HOST'),getenv('LTC_PORT'),getenv('LTC_USER'),getenv('LTC_PASS'),'LTC');
        return $ltc_client;
    }
    protected function getFALClient()
    {
        $fal_client = new Client(getenv('FAL_HOST'),getenv('FAL_PORT'),getenv('FAL_USER'),getenv('FAL_PASS'),'FAL');
        return $fal_client;
    }

    protected function getAllClicent($currency)
    {
        $client = new Client(getenv($currency.'_HOST'),getenv($currency.'_PORT'),getenv($currency.'_USER'),getenv($currency.'_PASS'),$currency);
        return $client;
    }

    protected function getBTGClient()
    {
        $btg_client = new Client(getenv('BTG_HOST'),getenv('BTG_PORT'),getenv('BTG_USER'),getenv('BTG_PASS'),'BTG');
        return $btg_client;
    }

    protected function getBCHClient()
    {
        $bch_client = new Client(getenv('BCH_HOST'),getenv('BCH_PORT'),getenv('BCH_USER'),getenv('BCH_PASS'),'BCH');
        return $bch_client;
    }

    //TODO  优化以上方法
    /*protected function getBCHClient()
    {

    }*/

    //TODO 查询数据库取出currency  优化getClient
    protected function getClient($currency)
    {
        $client = null;
        switch ($currency) {
            case 'BTC':
                $client = new Client(getenv('BTC_HOST'),getenv('BTC_PORT'),getenv('BTC_USER'),getenv('BTC_PASS'),'BTC');
                break;
            case 'LTC':
                $client = new Client(getenv('LTC_HOST'),getenv('LTC_PORT'),getenv('LTC_USER'),getenv('LTC_PASS'),'LTC');
                break;
            case 'FAL':
                $client = new Client(getenv('FAL_HOST'),getenv('FAL_PORT'),getenv('FAL_USER'),getenv('FAL_PASS'),'FAL');
                break;
            case 'BCH':
                $client = new Client(getenv('BCH_HOST'),getenv('BCH_PORT'),getenv('BCH_USER'),getenv('BCH_PASS'),'BCH');
                break;
            case 'BTG':
                $client = new Client(getenv('BTG_HOST'),getenv('BTG_PORT'),getenv('BTG_USER'),getenv('BTG_PASS'),'BTG');
                break;
        }
        return $client;
    }
}
