@extends('layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/market.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/index.css') }}">
@endsection
@section('content')
    <div class="container" id="app" v-colak style="[v-colak]{display:none}">
        <div class="row">
            <div class="m_title">
                @if(count($market) >  0 )
                    @foreach($market as $ma)
                    <div class="m_icon" style="background-image: url(public/front/images/market/fal.png)"><img src="{{publicPath('front/images/coin/') }}/{{$ma->currency}}.png"
                                                                                                               alt="currency icon"
                        style="width:32px;height: 32px;"></div>
                    <div class="m_text">{{$ma->full_currency}}({{$ma->currency}})</div>
                        @if($loop->index == 0)
                            <div class="m_line">|</div>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="panel panel-default" style="border:0;">
                <div class="panel-heading chart" style="text-align: right;font-size:18px;border:0;">24h&nbsp;Volume&nbsp;:&nbsp;<span id="_24h_volume"></span> {{$currency[1]}}&nbsp;|&nbsp;24h&nbsp;Change&nbsp;:&nbsp; <button type="button" class="btn btn-danger" style="font-size:16px;font-weight: 700"><span id="_24h_change"></span>%</button></div>
                <div class="panel-body">
                    <div id="chartdiv" style="width:100%; height:420px;"></div>
                    <div class="row text-center ope">
                        <a href="javascript:void(0)" id="c6M" data-time="16128" data-size="100" class="btn btn-sm btn-default candleget">6M</a>
                        <a href="javascript:void(0)" id="c2M" data-time="5376" data-size="100" class="btn btn-sm btn-default candleget">2M</a>
                        <a href="javascript:void(0)" id="c1M" data-time="2688" data-size="100" class="btn btn-sm btn-default candleget">1M</a>
                        <a href="javascript:void(0)" id="c2W" data-time="1344" data-size="100" class="btn btn-sm btn-default candleget">2W</a>
                        <a href="javascript:void(0)" id="c1W" data-time="672" data-size="100" class="btn btn-sm btn-default candleget">1W</a>
                        <a href="javascript:void(0)" id="c2D" data-time="192" data-size="100" class="btn btn-sm btn-default candleget">2D</a>
                        <a href="javascript:void(0)" id="c1D" data-time="96" data-size="100" class="btn btn-sm btn-default candleget">1D</a>
                        <a href="javascript:void(0)" id="c6H" data-time="24" data-size="100" class="btn btn-sm btn-default candleget">6H</a>
                        <a href="javascript:void(0)" id="c2H" data-time="8" data-size="100" class="btn btn-sm btn-default candleget">2H</a>
                        <a href="javascript:void(0)" id="c1H" data-time="4" data-size="100" class="btn btn-sm btn-default candleget">1H</a>
                        <a href="javascript:void(0)" id="c30m" data-time="2" data-size="100" class="btn btn-sm btn-default candleget">30m</a>
                        <a href="javascript:void(0)" id="c15m" data-time="1" data-size="100" class="btn btn-sm btn-nov candleget">15m</a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="market_id" value="{{$market_id}}">
        <div class="row transaction">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Buy {{$another}}({{$currency[0]}})</div>
                    <div class="panel-body">
                        <table id="buyfal">
                            <tr>
                                <td>You have</td>
                                <td><span id="buy_have" style="color:#3377ff">{{ $balances[$currency[1]] }}    </span>&nbsp;{{$currency[1]}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Buy</td>
                                <td>
                                    <input type="text" class="form-control" id="buy_buy" value="0.00000000">
                                </td>
                                <td class="text-center">FAL</td>
                            </tr>
                            {{--TODO 填充市场最新价格 buy_total  sell_total--}}
                            <tr>
                                <td>BID/Price</td>
                                <td><input type="text" class="form-control" id="buy_bid" value="{{$bid}}"></td>
                                <td class="text-center">BTC</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><input type="text" class="form-control" id="buy_total" value="0.00000000"></td>
                                <td class="text-center">BTC</td>
                            </tr>
                            <tr>
                                <td>Fee</td>
                                <td>(<span id="buy_fee_tatal">{{$fee}}</span>)&nbsp;<span id="buy_fee">0</span>{{$currency[1]}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Net.Total</td>
                                <td><span id="buy_net_total">0.00000000</span>&nbsp;{{$currency[1]}}</td>
                                <td></td>
                            </tr>
                            <tr style="margin-top:20px;">
                                <td></td>
                                <td class="text-center"><button {{--data-toggle="modal" data-target="#err_modal"--}} id="buy" class="btn btn-nov buy" style="width:75%;height:48px;font-size:24px;">Buy {{$currency[0]}}</button></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading" >Sell {{$another}}({{$currency[0]}})</div>
                    <div class="panel-body">
                        <table id="sellfal">
                            <tr>
                                <td>You have</td>
                                <td><span id="sell_have" style="color:#3377ff">{{ $balances[$currency[0]] }}</span>&nbsp;{{$currency[0]}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Sell</td>
                                <td><input type="text" class="form-control" id="sell_buy" value="0.00000000"></td>
                                <td class="text-center">FAL</td>
                            </tr>
                            <tr>
                                <td>ASK/Price</td>
                                <td><input type="text" class="form-control" id="sell_bid" value="{{$ask}}"></td>
                                <td class="text-center">BTC</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><input type="text" class="form-control" id="sell_total" value="0.00000000"></td>
                                <td class="text-center">BTC</td>
                            </tr>
                            <tr>
                                <td>Fee</td>
                                <td>(<span id="sell_fee_tatal" >{{$fee}}</span>)&nbsp;<span id="sell_fee">0</span>&nbsp;{{$currency[1]}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Net.Total</td>
                                <td><span id="sell_net_total">0.00000000</span>&nbsp;{{$currency[1]}}</td>
                                <td></td>
                            </tr>
                            <tr style="margin-top:20px;">
                                <td></td>
                                <td class="text-center"><button {{--data-toggle="modal" data-target="#succ_modal"--}} class="btn btn-nov sell" id="sell" style="width:75%;height:48px;font-size:24px;">Sell {{$currency[0]}}</button></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row record">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <input type="hidden" id="market" value="{{$market_id}}">
                    <div class="panel-heading">
                        <h3 class="">Asks | Sell orders</h3>
                        <h4 class="">Orderbook: <span>0.0000000</span>{{$currency[0]}}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="record_table asks">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>ASK(BTC)</td>
                                    <td>Amount({{$currency[0]}})</td>
                                    <td>Val(BTC)</td>
                                    <td>Total({{$currency[1]}})</td>
                                </tr>
                                </thead>
                                <tbody id="sell_order">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="">Bids | Buy orders</h3>
                        <h4 class="">Orderbook: <span>0.000000</span>{{$currency[1]}}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="record_table asks">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>ASK({{$currency[1]}})</td>
                                    <td>Amount({{$currency[0]}})</td>
                                    <td>Val({{$currency[1]}})</td>
                                    <td>Total({{$currency[1]}})</td>
                                </tr>
                                </thead>
                                <tbody id="buy_order">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row record">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="">Market history</h3>
                </div>
                <div class="panel-body">
                    <div class="record_table asks">
                        <table class="table">
                            <thead>
                            {{--Timestamp	Type	Price (BTC)	Volume (ETHD)	Volume (BTC)	Value (BTC)	--}}
                            <tr>
                                <td>Timestamp</td>
                                <td>Type</td>
                                <td>Price ({{$currency[1]}})</td>
                                <td>Volume ({{$currency[0]}})</td>
                                <td>Volume ({{$currency[1]}})</td>
                                <td>Value ({{$currency[1]}})</td>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($history) > 0)
                                @foreach($history as $h)
                                    @if($h->type == 1)
                                        <tr>
                                            <td>{{$h->created_at}}</td>
                                            <td style="color: red">SELL</td>
                                            <td style="color: red">{{ $h->last_price }}</td>
                                            <td style="color: red">{{ $h->volume }}</td>
                                            <td style="color: red">{{ $h->volume }}</td>
                                            <td style="color: red">{{ $h->volume }}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td>{{$h->created_at}}</td>
                                            <td style="color: green">BUY</td>
                                            <td style="color: green">{{ $h->last_price }}</td>
                                            <td style="color: green">{{ $h->volume }}</td>
                                            <td style="color: green">{{ $h->volume }}</td>
                                            <td style="color: green">{{ $h->volume }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!--true-->
        <div class="modal fade" id="succ_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"> </h4>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <i class="font_succ"></i>
                        <h2>Buy Falcoin success!</h2>
                        <p>The next time you can buy more</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-nov" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!--error-->
        <div class="modal fade" id="err_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"> </h4>
                    </div>
                    <div class="modal-body" style="text-align: center">
                        <i class="font_err"></i>
                        <h2>Buy Falcoin failure!</h2>
                        <p>Amount must be bigger than zero (0),Price cannot be zero (0).</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-nov" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" id="loading">
        <img width="80" height="80" src="{{ publicPath('front/images/index/loading.gif') }}" alt="">
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ publicPath('front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ publicPath('front/lib/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ publicPath('front/lib/amcharts.js') }}"></script>
    <script src="{{ publicPath('front/lib/serial.js') }}"></script>
    <script src="{{ publicPath('front/lib/amstock.js') }}"></script>
    <script src="{{ publicPath('front/lib/light.js') }}"></script>
    <script src="{{ publicPath('front/js/marketchar.js') }}"></script>
    <script src="{{ publicPath('front/lib/jquery.mousewheel.min.js') }}"></script>
    <script src="{{ publicPath('front/lib/jquery.mCustomScrollbar.min.js') }}"></script>
    <script src="{{ publicPath('front/js/common.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            $(".asks").mCustomScrollbar({
                theme: 'dark'
            })
        })

        $("#buy").unbind('click').on('click',function () {
            $("#loading").show();
            $.ajax({
                url:'{{ url("/market/trade") }}',
                data:{'type':$("#buy").attr('id'),'vol':$("#buy_buy").val(),'price':$("#buy_bid").val(),'total':$("#buy_total").val(),'fee':$("#buy_fee").text(),'buy_net_total':$("#buy_net_total").text(),'market':$("#market").val()},
                dataType:'json',
                type:'post',
                success:function (msg) {
                    if(msg.code == 200) {
                        toastr.success('success');
                        getOrder();
                    }else if(msg.code == 400) {
                        toastr.error(msg.message);
                    }
                    $("#loading").hide();
                },
                error:function (msg) {
                    $("#loading").hide();
                    var json=JSON.parse(msg.responseText);
                    if (json['errors']['buy']){
                        toastr.error(json['errors']['buy']);
                    }else if(json['errors']['price']){
                        toastr.error(json['errors']['price']);
                    }else if(json['errors']['total']){
                        toastr.error(json['errors']['total']);
                    }else if(json['errors']['buy_net_total']){
                        toastr.error(json['errors']['buy_net_total']);
                    }else (
                        toastr.error('error')
                    )
                }
            })
        });

        $("#sell").unbind('click').on('click',function () {
            $("#loading").show();
            $.ajax({
                url:'{{ url("/market/trade") }}',
                data:{'type':$("#sell").attr('id'),'vol':$("#sell_buy").val(),'price':$("#sell_bid").val(),'total':$("#sell_total").val(),'fee':$("#sell_fee").text(),'buy_net_total':$("#sell_net_total").text(),'market':$("#market").val()},
                dataType:'json',
                type:'post',
                success:function (msg) {
                    if(msg.code == 200) {
                        toastr.success('success');
                        getOrder();
                    }else if(msg.code !== 200) {
                        toastr.error(msg.message);
                    }
                    $("#loading").hide();
                },
                error:function (msg) {
                    $("#loading").hide();
                    var json=JSON.parse(msg.responseText);
                     if (json['errors']['buy']){
                        toastr.error(json['errors']['buy']);
                     }else if(json['errors']['price']){
                        toastr.error(json['errors']['price']);
                     }else if(json['errors']['total']){
                        toastr.error(json['errors']['total']);
                     }else if(json['errors']['buy_net_total']){
                        toastr.error(json['errors']['buy_net_total']);
                     }else {
                         toastr.error('error')
                     }
                }
            })
        });
    </script>
@endsection