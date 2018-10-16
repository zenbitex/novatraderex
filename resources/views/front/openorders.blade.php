@extends('layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ publicPath('front/css/index.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ publicPath('front/css/open.css') }}">
@endsection
@section('content')
    <div id="wrap-contant">
        <div class="contant">
            <div class="box2">
                <h4>{{ trans('test.Open_orders') }}</h4>
                <div class="table2">
                    <ul>
                        <li>
                            <div>#</div>
                            <div>Timestamp</div>
                            <div>Marker</div>
                            <div>Type</div>
                            <div>Initial volume</div>
                            <div>Residual volume</div>
                            <div>Price</div>
                            <div>operation</div>
                        </li>
                        @if(count($open_order) > 0)
                            @foreach($open_order as $order)
                        <li>
                            <div>{{$loop->iteration}}</div>
                            <div>{{$order->created_at}}</div>
                            <div><span>{{$order->market_id}}</span></div>
                            @if($order->type == 1)
                                <div class="red"><span>sell</span></div>
                                @else
                                <div class="greed"><span>buy</span></div>
                            @endif

                            <div>{{$order->volume}}</div>
                            <div>{{$order->rvolume}}</div>
                            <div>{{$order->price}}</div>
                            <div><a data-toggle="modal" data-target="" style="color:#3377ff" href="javascrip:;" class="cancel" orderid="{{$order->id}}">cancel</a></div>
                        </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="pin_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please enter the two level password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email" class="control-label">pin:</label>
                        <input type="password" class="form-control" id="pin" placeholder="Please input a password" style="box-sizing:border-box">
                        <div class="alert alert-danger error" id="send_pass_error" style="margin-top:10px;display:none">
                            <span class="glyphicon glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            <span class="tips"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="sen_pin" type="button" class="btn btn-nov">OK</button>
                    <button type="button" class="btn btn-nov" data-dismiss="modal">Close</button>
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
    <script src="{{ publicPath('front/js/common.js') }}"></script>
    <script src="{{ publicPath('front/js/conf.js') }}"></script>
    <script type="text/ecmascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".cancel").unbind('click').on('click',function () {
            orderid = $(this).attr('orderid');
            $("#pin_modal").modal('show');
        });
        $(function() {
            $("#sen_pin").click(function() {
                if($("#pin").val().length == 0) {
                    $("#send_pass_error").show().find(".tips").text('The content you entered cannot be empty')
                    return
                }
                $('#loading').show();
                $.ajax({
                    url:"{{ url('order/cancel') }}",
                    data:{'pin':$('#pin').val(),'orderid':orderid},
                    dataType:'json',
                    type:'POST',
                    success:function (msg) {
                        $('#loading').hide();
                        if(msg.code == 403) {
                            toastr.error(msg.message);return;
                        }else if(msg.code == 404) {
                            toastr.error(msg.message);return;
                        }else if(msg.code == 200) {
                            toastr.success(msg.message);
                            $("#pin_modal").modal('hide');
                            window.location.href = '{{ url("order/open") }}';
                            return;
                        }else if(msg.code == 400) {
                            toastr.error(msg.message);return;
                        }
                    },
                    error:function (msg) {
                        $('#loading').hide();
                        $("#pin_modal").hide();
                        var json=JSON.parse(msg.responseText);
                        toastr.error(json.message);
                    }
                });
            })
        })
    </script>
@endsection