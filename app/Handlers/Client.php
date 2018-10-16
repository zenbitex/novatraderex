<?php
namespace App\Handlers;
use App\Handlers\jsonRPCClient;
class Client {
    private $uri;
    private $jsonrpc;

    //添加cli_flag
    function __construct($host, $port, $user, $pass,$cli_flag)
    {
        $this->uri = "http://" . $user . ":" . $pass . "@" . $host . ":" . $port . "/";

        $this->jsonrpc = new jsonRPCClient($this->uri,false,$cli_flag);
    }

    function getInfo()
    {
        $info = $this->jsonrpc->getinfo();
        return $info['balance'];
    }

    function getBalance($user_session)
    {
        return $this->jsonrpc->getbalance("falchat(" . $user_session . ")", 0);
        //return 21;
    }

    function getAddress($user_session)
    {
        return $this->jsonrpc->getaccountaddress("falchat(" . $user_session . ")");
        //string
    }

    function getAddressList($user_session)
    {
        return $this->jsonrpc->getaddressesbyaccount("falchat(" . $user_session . ")");
        //return array("1test", "1test");
    }

    function getTransactionList($user_session)
    {
        return $this->jsonrpc->listtransactions("falchat(" . $user_session . ")", 50);
        //array
    }

    function getNewAddress($user_session)
    {
        //	echo "indise add";
        return $this->jsonrpc->getnewaddress("falchat(" . $user_session . ")");
        //return "1test";
    }

    function withdraw($user_session, $address, $amount)
    {
        return $this->jsonrpc->sendfrom("falchat(" . $user_session . ")", $address, (float)$amount,1);
        //true or error json
        //return "ok wow";
    }
    function move($user_session,$other_account, $amount)
    {
        return $this->jsonrpc->move("falchat(" . $user_session . ")","falchat(" . $other_account . ")", (float)$amount);
        //return "ok wow";
    }
    //验证地址
    function validateaddress($address)
    {
        return $this->jsonrpc->validateaddress($address);
        //return "ok wow";
    }
}
?>