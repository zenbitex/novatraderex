@extends('layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ publicPath('front/css/index.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/deposit.css') }}">
@endsection
@section('content')
    <div id="wrap-contant">
        <div class="contant">
            <div class="bitcoin">
                <div class="magin0">
                    <h4>{{ trans('test.Deposit_history') }}</h4>
                    <!--有数据显示class=show,没有数据显示class=hidd-->
                    @if(count($deposits) > 0)
                    <div class="box show">
                        <ul>
                            <li><div><b>#</b></div><div>Currency</div><div>Timestamp</div><div>To address</div><div>Amount</div><div>Status</div></li>
                                @foreach($deposits as $deposit)
                            <li>
                                <div class="btnn"><b>{{$loop->index + 1}}</b><a>{{$deposit['currency']}}</a></div>
                                <div>{{$deposit['currency']}}</div>
                                <div>{{$deposit['time_seen']}}</div>
                                <div>{{$deposit['tx_address']}}</div>
                                <div>{{$deposit['tx_amount']}}</div>
                                <div class="suc">{{$deposit['status']}}</div>
                            </li>
                                <div class="tran">Transaction ID: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span> {{ $deposit['tx_txid'] }} </span></div>
                                @endforeach
                        </ul>
                    </div>
                    @else
                    <div class="box hidd">
                        <ul>
                            <li><div><b>#</b></div><div>Currency</div><div>Timestamp</div><div>To address</div><div>Amount</div><div>Status</div></li>
                            <li>
                                <p>No withdrawal history available.</p>
                            </li>
                        </ul>
                        <div class="disclamer">
                            <span>Disclamer:</span>
                            <p>
                                Withdrawals are processed in bulk every 15 minute. Once processed your withdrawal will get status sent and Transaction ID will be available.<br>
                                Status Manual means that your withdrawal will be processed manually from cold storage, or any other reason withdrawal failed. Please wait, we are not working
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ publicPath('front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ publicPath('front/js/common.js') }}"></script>
@endsection