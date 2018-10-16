<?php
//切割用户手机号的区号和号码
function splitPhone($phone)
{
    $flag = strpos($phone, '-');
    $res['region'] = substr($phone, 0,$flag);
    $res['phone'] = substr($phone, $flag+1);
    return $res;
}
//根据配置文件判断是否添加public vhost为什么会改了- -。
function publicPath($url)
{
    if(getenv('IS_PUBLIC') == 'TRUE'){
        return URL::asset('public/'.$url);
    }
    return URL::asset($url);
}
//返回2FA 类型
function get2faType($str)
{
    $res = '';
    switch ($str) {
        case 1:
            $res = 'Authy';
            break;
        case 2:
            $res = 'SMS';
            break;
        case 3:
            $res = 'Google Authenticator';
            break;
    }
    return $res;
}

/**
 * @获取指定虚拟货币对比特币的汇率
 * @param
 * @return
 */
function getRate($coin='')
{
    $api_url = 'https://api.coinmarketcap.com/v1/ticker/'.$coin;
    $res = file_get_contents($api_url);
    return $res;
}

