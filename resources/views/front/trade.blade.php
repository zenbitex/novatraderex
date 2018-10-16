@extends('layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/index.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/trade.css') }}">
    @endsection
@section('content')
    <div id="wrap-contant">
        <div class="contant">
            <div>
                <h2>Available coins for trade</h2>
                {{--<p>Strart:<a class="xian">Name</a><a>Latest</a></p>--}}<br>
            </div>
            <div class="box0">
                @if(count($market) > 0)
                    @foreach($market as $key=>$value)
                        <div class="list0">
                            <div><img class="currency_img" src="{{publicPath('front/images/coin/') }}/{{ $value[0]->to_currency }}.png" alt=""><div class="bit0">{{ $value[0]->to_full_currency }}({{$key}})</div></div>
                                <div>
                                    @foreach($value as $mm)
                                        <span class="to_currency_c"> <img class="to_currency_img" src="{{publicPath('front/images/coin/') }}/BTC.png" alt=""><a href="market/{{$mm->market_name}}">Trade with {{$mm->base_full_currency}}</a></span>
                                    @endforeach
                                </div>
                        </div>
                    @endforeach
                @endif
                {{--<div class="list0">
>>>>>>> staging
                    <div><div class="bit0">Falcoin(FAL)</div></div>
                    <div>
                        <span><a>Trade with Bitcoin</a></span>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ publicPath('front/js/common.js') }}"></script>
@endsection