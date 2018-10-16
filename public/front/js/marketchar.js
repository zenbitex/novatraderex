$(function () {
    get24hInfo();
    getOrder();
});
function get24hInfo() {
    $.ajax({
        url:'get24hInfo',
        data:{'market_id':$("#market_id").val()},
        dataType:'json',
        type:'post',
        success:function(msg) {
            if(msg.code == 200) {
                $("#_24h_change").html(msg.result._24h_change);
                $("#_24h_volume").html(msg.result._24h_volume);
            }
        }
    });
}

function getOrder() {
    $.ajax({
        url:'order',
        data:{'market_id':$("#market").val()},
        dataType:'json',
        type:'post',
        success:function(msg) {
            if(msg.code == 200) {
                json = msg.msg
                buy = eval(json.buy)
                sell = eval(json.sell)
                $("#buy_order").empty();
                $("#sell_order").empty();
                var buyhtml ;
                var sellhtml;
                if(typeof (buy) != 'undefined') {
                    for(var i=0; i<buy.length; i++)
                    {
                        buyhtml += '<tr><td>'+buy[i].price+'</td><td>'+buy[i].rvolume+'</td><td>'+(buy[i].price * buy[i].rvolume).toFixed(8)+'</td><td>'+0.00000000+'</td></tr>';

                    }
                }
                if(typeof (sell) != 'undefined') {
                    for(var i=0; i<sell.length; i++)
                    {
                        sellhtml += '<tr><td>'+sell[i].price+'</td><td>'+sell[i].rvolume+'</td><td>'+(sell[i].price * sell[i].volume).toFixed(8)+'</td><td>'+0.00000000+'</td></tr>';
                    }
                }
                $("#sell_order").append(sellhtml);
                $("#buy_order").append(buyhtml);
            }
        }
    });
}
$(function () {
    var buy_have = Number($('#buy_have').html());
    var buy_bid = Number($('#buy_bid').val());
    var buy_fee_val = $('#buy_fee_tatal').html();
    buy_fee_val = buy_fee_val.substring(0, buy_fee_val.indexOf("%")) * 0.01;
    console.log(buy_fee_val)
    $('#buyfal tr td input').on('keyup',function(){
        var id = $(this).attr('id')
        if(id == 'buy_buy') {
            $('#buy_total').val(($('#buy_buy').val() * buy_bid).toFixed(8))
            if(Number($('#buy_total').val()) > buy_have) {
                $('#buy_buy').val((buy_have / buy_bid).toFixed(8))
                $('#buy_total').val(($('#buy_buy').val() * buy_bid).toFixed(8))
            }
            buy_fee()
            buy_net_total()
        }
        if(id == 'buy_bid') {
            buy_bid = $('#buy_bid').val()
            // $('#buy_total').val(($('#buy_buy').val() * buy_bid).toFixed(8))
            $('#buy_buy').val((buy_have / buy_bid).toFixed(8))
            if(Number($('#buy_total').val()) > buy_have) {
                $('#buy_buy').val((buy_have / buy_bid).toFixed(8))
                $('#buy_total').val(($('#buy_buy').val()* buy_bid).toFixed(8))
                buy_fee()
                buy_net_total()
                return
            }
            // $('#buy_total').val(($('#buy_buy').val() * buy_bid).toFixed(8))
            buy_fee()
            buy_net_total()
        }
        if(id == 'buy_total') {
            if(Number($('#buy_total').val()) > buy_have) {
                $('#buy_buy').val((buy_have / buy_bid).toFixed(8))
                $('#buy_total').val(($('#buy_buy').val() * buy_bid).toFixed(8))
            }
            $('#buy_buy').val(($('#buy_total').val() / buy_bid).toFixed(8))
            buy_fee()
            buy_net_total()
        }
    })
    $('#buyfal tr td input').on('blur',function(){
        var id = $(this).attr('id')
        if(id == 'buy_buy') {
            buy_rule()
            if($('#buy_buy').val() == '') {
                $('#buy_buy').val('0.00000000')
                return
            }
            $('#buy_buy').val(($('#buy_buy').val() - 0.00000000).toFixed(8))
        }
        if(id == 'buy_bid') {
            buy_rule()
            if($('#buy_bid').val() == '') {
                $('#buy_bid').val('0.00000000')
                return
            }
            $('#buy_bid').val(($('#buy_bid').val() - 0.00000000).toFixed(8))
        }
        if(id == 'buy_total') {
            buy_rule()
            if($('#buy_total').val() == '') {
                $('#buy_total').val('0.00000000')
                return
            }
            $('#buy_total').val(($('#buy_total').val() - 0.00000000).toFixed(8))
        }
    })

    function buy_fee() {
        $('#buy_fee').html( (Number($('#buy_total').val()) * buy_fee_val).toFixed(8))
        console.log($('#buy_fee').html())
    }
    function buy_net_total() {
        $('#buy_net_total').html(($('#buy_total').val() - $('#buy_fee').html()).toFixed(8))
    }
    function buy_rule() {
        $('#buy_buy').val() < 0.00000001 ? $('#buy_buy').val('0.00000000') : $('#buy_buy').val()
        $('#buy_bid').val() < 0.00000001 ? $('#buy_bid').val('0.00000000') : $('#buy_bid').val()
        if($('#buy_total').val() <= 0.00000002) {
            $('#buy_buy').val('0.00000000')
            $('#buy_total').val('0.00000000')
            buy_fee()
            buy_net_total()
        }
    }

    var sell_have = Number($('#sell_have').html())
    var sell_bid = Number($('#sell_bid').val())
    var sell_fee_val = $('#sell_fee_tatal').html();
    sell_fee_val = sell_fee_val.substring(0, sell_fee_val.indexOf("%")) * 0.01;
    $('#sellfal tr td input').on('keyup',function(){
        var id = $(this).attr('id')
        if(id == 'sell_buy') {
            $('#sell_total').val(($('#sell_buy').val() * sell_bid).toFixed(8))
            if($('#sell_buy').val() > sell_have) {
                $('#sell_buy').val(sell_have)
                $('#sell_total').val(($('#sell_buy').val() * sell_bid).toFixed(8))
            }
            sell_fee()
            sell_net_total()
        }
        if(id == 'sell_bid') {
            sell_bid = $('#sell_bid').val()
            $('#sell_buy').val((sell_have / sell_bid).toFixed(8))
            // $('#sell_total').val(($('#sell_buy').val() * sell_bid).toFixed(8))
            if(Number($('#sell_buy').val()) > sell_have) {
                $('#sell_buy').val((sell_have).toFixed(8))
                $('#sell_total').val(($('#sell_buy').val()* sell_bid).toFixed(8))
                sell_fee()
                sell_net_total()
                return
            }
            sell_fee()
            sell_net_total()
        }
        if(id == 'sell_total') {
            $('#sell_buy').val(($('#sell_total').val() / sell_bid).toFixed(8))
            if($('#sell_buy').val() > sell_have) {
                $('#sell_buy').val(sell_have)
                $('#sell_total').val(($('#sell_buy').val() * sell_bid).toFixed(8))
                sell_fee()
                sell_net_total()
                return
            }
            $('#sell_buy').val(($('#sell_total').val() / sell_bid).toFixed(8))
            sell_fee()
            sell_net_total()
        }
    })
    $('#sellfal tr td input').on('blur',function(){
        var id = $(this).attr('id')
        if(id == 'sell_buy') {
            sell_rule()
            if($('#sell_buy').val() == '') {
                $('#sell_buy').val('0.00000000')
                return
            }
            $('#sell_buy').val(($('#sell_buy').val() - 0.00000000).toFixed(8))
        }
        if(id == 'sell_bid') {
            sell_rule()
            if($('#sell_bid').val() == '') {
                $('#sell_bid').val('0.00000000')
                return
            }
            $('#sell_bid').val(($('#sell_bid').val() - 0.00000000).toFixed(8))
        }
        if(id == 'sell_total') {
            sell_rule()
            if($('#sell_total').val() == '') {
                $('#sell_total').val('0.00000000')
                return
            }
            $('#sell_total').val(($('#sell_total').val() - 0.00000000).toFixed(8))
        }
    })

    function sell_fee() {
        $('#sell_fee').html( ($('#sell_total').val() * sell_fee_val).toFixed(8))
    }
    function sell_net_total() {
        $('#sell_net_total').html(($('#sell_total').val() - $('#sell_fee').html()).toFixed(8))
    }
    function sell_rule() {
        $('#sell_buy').val() < 0.00000001 ? $('#sell_buy').val('0.00000000') : $('#sell_buy').val()
        $('#sell_bid').val() < 0.00000001 ? $('#sell_bid').val('0.00000000') : $('#sell_bid').val()
        if($('#sell_total').val() <= 0.00000002) {
            $('#sell_buy').val('0.00000000')
            $('#sell_total').val('0.00000000')
            sell_fee()
            sell_net_total()
        }
    }
})



AmCharts.ready( function() {
    Number.prototype.noExponents = function () {
        var data = String(this).split(/[eE]/);
        if (data.length == 1) return data[0];

        var z = '',
            sign = this < 0 ? '-' : '',
            str = data[0].replace('.', ''),
            mag = Number(data[1]) + 1;

        if (mag < 0) {
            z = sign + '0.';
            while (mag++) z += '0';
            return z + str.replace(/^\-/, '');
        }
        mag -= str.length;
        while (mag--) z += '0';
        return str + x;
    }

    function myValue(value, valueText, valueAxis) {
        return value
    }


    var chartData = [];

    var chart = AmCharts.makeChart( "chartdiv", {
        type: "stock",
        "theme": "light",
        dataDateFormat: "YYYY-MM-DD HH:NN:SS",
        balloonDateFormat: "YYYY-MM-DD HH:NN:SS",
        numberFormatter: {
            usePrefixes: false,
            precision: -1,
            decimalSeparator: ".",
            thousandsSeparator: " "
        },
        categoryAxesSettings: {
            maxSeries: 0,
            minPeriod: "ss",
            equalSpacing: true,
        },
        dataSets: [ {
            fieldMappings: [ {
                fromField: "oopen",
                toField: "oopen"
            }, {
                fromField: "oclose",
                toField: "oclose"
            }, {
                fromField: "ohigh",
                toField: "ohigh"
            }, {
                fromField: "olow",
                toField: "olow"
            }, {
                fromField: "ovolume",
                toField: "ovolume"
            }, {
                fromField: "close",
                toField: "value"
            }, {
                fromField: "average",
                toField: "average"
            } ],

            color: "#7f8da9",
            dataProvider: chartData,
            title: " ",
            categoryField: "date"
        } ],
        panels: [ {
            title: "Price",
            showCategoryAxis: false,
            marginRight: 80,
            percentHeight: 75,
            valueAxes: [ {
                labelFunction: function (value, valueText, valueAxis) {
                    return value.noExponents();
                },
                gridAlpha: 0.25,
                id: "v1",
                dashLength: 1,
                position: "left",
            }],

            categoryAxis: {
                dashLength: 1,
                gridAlpha: 0.25,
            },

            stockGraphs: [ {
                type: "candlestick",
                id: "g1",
                balloonText: "Open:<b>[[oopen]]</b><br>Low:<b>[[olow]]</b><br>High:<b>[[ohigh]]</b><br>Close:<b>[[oclose]]</b><br>Average:<b>[[average]]</b>",
                openField: "oopen",
                closeField: "oclose",
                highField: "ohigh",
                lowField: "olow",
                valueField: "oclose",
                lineColor: "#038500",
                fillColors: "#038500",
                negativeLineColor: "#a50000",
                negativeFillColors: "#a50000",
                fillAlphas: 1,
                useDataSetColors: false,
                showBalloon: true,
                proCandlesticks: true
            } ],

            stockLegend: {
                markerType: "none",
                markerSize: 0,
                forceWidth: true,
                labelWidth: 0,
                labelText: "",
                periodValueText: "",
                periodValueTextRegular: "[[close]]"
            }
        },

            {
                title: "Volume",
                percentHeight: 25,
                marginTop: 1,
                showCategoryAxis: true,
                valueAxes: [ {
                    labelFunction: function (value, valueText, valueAxis) {
                        return value.noExponents();
                    },
                    inside: false,
                    precision: 8,
                    position: "right",
                    dashLength: 5
                } ],

                categoryAxis: {
                    dashLength: 5
                },

                stockGraphs: [ {
                    valueField: "ovolume",
                    type: "column",
                    showBalloon: true,
                    fillAlphas: 1
                } ],

                stockLegend: {
                    markerType: "none",
                    markerSize: 0,
                    periodValueText: "",
                    periodValueTextRegular: "[[value]]"
                }
            }
        ],


        chartScrollbarSettings: {
            enabled: false,
        },

        chartCursorSettings: {
            valueLineEnabled: true,
            valueBalloonsEnabled: true,
            zoomable: false
        }
    });

    var myButton = $("#c15m");
    var updatehistory;

    $(".candleget").unbind('click').on("click", function() {
        clearTimeout(updatehistory);
        var myself = $(this);
        myButton.removeClass('btn-success btn-danger btn-warning').addClass('btn-default')
        myself.removeClass('btn-success btn-danger btn-default').addClass('btn-warning')
        myButton = myself;
        var data_time = ($(this).attr('data-time')) ? $(this).attr('data-time') : 1;
        updateChart(data_time);
    });

    chart.addListener("dataUpdated", function (event) {
        chart.zoomOut();
    });

    var updatechart_c = 300;
    updatehistory = setTimeout(updateChart, 100);

    function updateChart(data_time) {
        chartData.length = 0;
        (data_time) ? data_time = data_time : data_time = myButton.attr('data-time');
        $.ajax({
            url:'api',
            data:{'stamp':data_time,'market_id':$("#market_id").val()},
            dataType:'json',
            type:'post',
            success:function(msg) {
                result = msg;
                var i = 0;
                for (var key in result) {
                    if (!result.hasOwnProperty(key)) continue;
                    var row = result[key];
                    chartData[i] = {
                        date: row.created_at,
                        oopen: row.open,
                        oclose: row.close,
                        ohigh: row.high,
                        olow: row.low,
                        ovolume: row.volume,
                        average: row.average,
                        value: row.average
                    };
                    i++;
                }
                chart.validateData();
            }
        });
        if (updatechart_c >= 1) {
            updatehistory = setTimeout(updateChart, 9000);
            updatechart_c = updatechart_c - 1;
        }

    }

//updateChart()
});
