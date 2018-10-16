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
                    <h4 class="withdrawal">{{ trans('test.Withdrawal_history') }}</h4>
                    <!--有数据显示class=show,没有数据显示class=hidd-->
                    @if(count($allhistory) > 0)
                    <div class="box show">
                        <ul>
                            <li><div><b>#</b></div><div>Currency</div><div>Timestamp</div><div>To address</div><div>Amount</div><div>Status</div></li>
                            @foreach($allhistory as $history)
                            <li>
                                <div class="btnn"><b>1</b><a>{{$history['currency']}}</a></div>
                                <div>{{$history['time_requested']}}</div>
                                <div>{{$history['tx_address']}}</div>
                                <div>{{$history['tx_amount']}}</div>
                                <div class="suc">{{$history['status']}}</div>
                            </li>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ publicPath('front/lib/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ publicPath('front/js/common.js') }}"></script>
@endsection