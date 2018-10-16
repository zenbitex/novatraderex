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
                    <h4>{{ trans('test.Order_history') }}</h4>
                    <!--有数据显示class=show,没有数据显示class=hidd-->
                    @if(count($history) > 0)
                        <div class="box show">
                            <ul>
                                <li>
                                    <div><b>#</b></div>
                                    <div>Timestamp</div>
                                    <div>Type</div>
                                    <div>Price</div>
                                    <div>Volume</div>
                                    <div>Fee</div></li>
                                @foreach($history as $h)
                                    <li>
                                        <div class="btnn"><b>{{$loop->iteration}}</b></div>
                                        <div>{{ date('Y-m-d H:i:s',$h->created_at)}}</div>
                                        @if($h->type == 1)
                                            <div style="color: red">sell</div>
                                            @else
                                            <div style="color: green">buy</div>
                                        @endif
                                        <div>{{$h->last_price}}</div>
                                        <div>{{$h->volume}}</div>
                                        <div>{{$h->fee}}</div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="box show">
                            <ul>
                                <li>
                                    <div><b>#</b></div>
                                    <div>Timestamp</div>
                                    <div>Type</div>
                                    <div>Price</div>
                                    <div>Volume</div>
                                    <div>Fee</div>
                                </li>
                                <li>

                                </li>
                            </ul>

                            <div class="disclamer">
                                <p>No withdrawal history available.</p>
                                {{--<span>Disclamer:</span>
                                <p>
                                    Withdrawals are processed in bulk every 15 minute. Once processed your withdrawal will get status sent and Transaction ID will be available.<br>
                                    Status Manual means that your withdrawal will be processed manually from cold storage, or any other reason withdrawal failed. Please wait, we are not working
                                </p>--}}
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