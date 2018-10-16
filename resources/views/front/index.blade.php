@extends('layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/index.css') }}">
@endsection
@section('content')
<div id="wrap-contant">
    <div class="contant">
        <div class="wallets">
            <h3>{{ trans('test.balance') }}</h3>
            {{--<div class="wenzi">
                <div>Your unique txcode to receive funds from another user on NovaTraderex</div>
                <div><span>ic0ujlqmr6awwgk9iersoh3yj774osc23m4ioq5pwip4mx1a3qmjbbh3jtjemxzlf5hhy81sncfrdmhba8qhzgn0vy</span></div>
                <div>Waiting for incoming transaction? Click here to get status!</div>
            </div>--}}
        </div>
        <div class="bitcoin">
            <div class="box">
                <ul>
                    <li><div></div><div>Currency</div><div>Balance</div><div>In trades</div><div>BTC Value</div></li>
                        @foreach($balance as $currency)
                            <li>
                                <div class="btnn ">
                                    <span class="glyphicon glyphicon-plus-sign getaddress" value="{{$currency['currency']}}"></span>
                                    <span class="glyphicon glyphicon-minus-sign getwithdraw" value="{{$currency['currency']}}"></span>
                                    <div class="wallet_warp">
                                        <img class="wallet_flag_img" src="{{publicPath('front/images/coin/') }}/{{$currency['currency']}}.png" alt="">
                                        <a class="wallet_flag">{{$currency['full_currency']}}</a>
                                    </div>
                                </div>
                               {{-- <div class="doww">
                                <span>
                                Bitcoin
                                    <ul>
                                        <li><span>BTC</span></li>
                                        <li><span>ETH</span></li>
                                    </ul>
                               </span>
                                </div>--}}
                                @if($currency['currency'] == 'BTC')
                                    <div><a href=""></a></div>
                                    @else
                                    <div><a href="http://www.novatraderex.com/market/{{$currency['currency']}}_BTC">Exchange</a></div>
                                    @endif
                                <div class="amount">{{$currency['balance'] - $currency['trade']}}</div>
                                <div>{{$currency['trade']}}</div>
                                <div>{{$currency['balance']}}</div>
                            </li>
                        @endforeach
                    <li>
                        {{--<div></div><div></div><div></div><div></div>
                        <div>
                            <strong>Est.BTC</strong>
                            <div class="num">17.58903862</div>
                        </div>--}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div style="display: none;" id="loading">
    <img width="80" height="80" src="{{ publicPath('front/images/index/loading.gif') }}" alt="">
</div>
@include('layout.indexmodal')
@endsection
@section('script')
    @parent
    <script src="{{ publicPath('front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ publicPath('front/js/index.js') }}"></script>
    <script src="{{ publicPath('front/lib/jquery.qrcode.min.js') }}"></script>
    <script src="{{ publicPath('front/js/conf.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //获取二维码
        $(".getaddress").unbind("click").bind('click',function () {
            var currency    = $(this).attr('value');
            $(".withdraw_currency").html(currency);
            $("#loading").show();
            $.ajax({
                url:"{{url('wallet/getaddress')}}",
                data:{'currency':$(this).attr('value')},
                type:'post',
                datatype:'json',
                success:function(msg) {
                    if(msg.code == 200){
                        $("#loading").hide();
                        $("#explain").modal('show');
                        $('#qrcode').text('');
                        $(".modal_address").text(msg.address);
                        $('#qrcode').qrcode(msg.address);
                        $("#modal_address").val(msg.address);
                        return;
                    }else if(msg.code == 400){
                        toastr.error('error!');
                        return;
                    }
                },
                error:function (msg) {
                    var json=JSON.parse(msg.responseText);
                    toastr.error(json['errors']['currency']);
                }
            });
        });
        //withdraw
        $(".getwithdraw").unbind("click").bind('click',function (){
            var currency    = $(this).attr('value');
            var amount      = $(this).parent().parent().find('.amount').text();
            $(".withdraw_currency").html(currency);
            $("#loading").show();
            $.ajax({
                url:'{{ url('market/getTxFee') }}',
                data:{'currency':currency},
                dataType:'json',
                type:'post',
                success:function (msg) {
                    if(msg.code == 200) {
                        $("#withdrawFee").attr('value',msg.message);
                        $("#loading").hide();
                        $("#qukuan").modal('show');
                    }else if(msg.code == 400) {
                        $("#loading").hide()
                        $("#qukuan").hide()
                        return;
                    }
                },
                error:function (msg) {
                    toastr.error('error');
                }
            });
            $("#maxvalue").text(amount);
            $("#dowithdraw").unbind("click").bind('click',function () {
                $("#loading").show()
                if ($("#withdrawAddress").val() == ''){
                    toastr.error("address error");
                    return;
                }else if($("#withdrawAmount").val() == ''){
                    toastr.error("amount error");
                    return;
                }else if($("#withdrawPin").val() == ''){
                    toastr.error("pin error");
                    return;
                }else if($("#withdrawAmount").val() > amount){
                    toastr.error("balance is not enough");
                    return;
                }
                $.ajax({
                    url:"{{url('wallet/withdraw')}}",
                    data:{
                        'address':$("#withdrawAddress").val(),
                        'amount':$("#withdrawAmount").val(),
                        'fee':$("#withdrawFee").val(),
                        'pin':$("#withdrawPin").val(),
                        'currency':currency
                    },
                    type:'post',
                    datatype:'json',
                    success:function(msg) {
                        if(msg.code == 200){
                            $("#loading").hide();
                            // TODO 关闭modal 提示成功
                            toastr.success(msg.message);
                            $("#qukuan").modal('hide');
                            return;
                        }else if (msg.code == 403){
                            // TODO  提示失败
                            $("#loading").hide();
                            toastr.error(' pin error');
                        }else if(msg.code == 400){
                            $("#loading").hide();
                            toastr.error(msg.message);
                        }
                    },
                    error:function (msg) {
                        var json=JSON.parse(msg.responseText);
                        // TODO  提示失败
//                        console.log(json['errors']['pass']);
                        if (json['errors']['address']){
                            toastr.error(json['errors']['address']);
                        }else if(json['errors']['amount']){
                            toastr.error(json['errors']['amount']);
                        }else if(json['errors']['pin']){
                            toastr.error(json['errors']['pin']);
                        }
                    }
                });
            })
        } );
        /*copy address*/
        function copyText(obj){
            try{
                var rng = document.getElementById('modal_address');
                rng.select();
                document.execCommand('copy', true);
                toastr.success("已经复制到粘贴板!你可以使用Ctrl+V 贴到需要的地方去了哦!");
            }catch(e){
                toastr.error("您的浏览器不支持此复制功能，请选中相应内容并使用Ctrl+C进行复制!");
            }
        }
    </script>
@endsection
{{--
<script src="{{ publicPath('public/front/lib/jquery-3.2.1.min.js') }}"></script>
<script src="{{ publicPath('public/front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ publicPath('public/front/js/index.js') }}"></script>
</body>
</html>--}}
