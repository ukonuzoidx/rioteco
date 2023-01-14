@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
    <div class="dashboard-section pt-120 bg--section">
        <div class="container">
            <section class="games-section bg--section pb-120">
                <div class="container">
                    <ul class="highlow-time-duration pb-50">
                        @forelse($gameSettings as $gameSetting)
                            <li class="highlight">
                                <a href="javascript:void(0)" class="gameTime " data-time="{{$gameSetting->time}}"
                                   data-unit="{{$gameSetting->unit}}">
                                    <i class="las la-clock"></i>
                                    {{$gameSetting->time}} {{$gameSetting->unit}}
                                </a>
                            </li>
                        @empty
                        @endforelse
                    </ul>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card custom--card">
                                <div class="card-body">
                                    <div id="graph"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card custom--card">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Current') {{$currency->name}} @lang('Price') : <span
                                            id="cryptoPrice"></span> @lang("USD")</h5>
                                </div>


                                <div class="card-body text-center">
                                    <span class="trade-user-price"></span>
                                    <form id="playGame">
                                        <div class="predict-group">
                                            <div class="input-group">
                                                <input type="text"
                                                       onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                                       placeholder="@lang('Enter Amount')"
                                                       class="form-control cmn--form--control bg--section" required=""
                                                       name="amount">
                                                <span class="input-group-text bg--info cmn--form--control">
                                                    {{ $general->cur_text }}
                                                </span>
                                            </div>

                                            <div class="highlow-predict">
                                                <button class="cmn--btn border-0 btn--success highlowButton"
                                                        type="submit" name="highlow" value="1">
                                                    <i class="las la-arrow-up"></i>@lang('High')
                                                </button>
                                                <button class="cmn--btn border-0 btn--danger highlowButton"
                                                        type="submit" name="highlow" value="2">
                                                    <i class="las la-arrow-down"></i>@lang('Low')
                                                </button>
                                            </div>
                                            <div class="clock w-100"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{asset('assets/css/flipclock.css')}}">
@endpush

@push('script-lib')
    <script src="{{asset('assets/js/flipclock.min.js')}}"></script>
    <script src="{{asset($activeTemplateTrue.'user/plot/plotly-latest.min.js')}}"></script>
@endpush
@push('script')
    <script>
        "use strict";
        var arrayLength = 15;
        var newArray = [];
        var xArray = [];
        var timezone;
        var gtime;
        var coinSymbol = "{{$currency->symbol}}";

        for (var i = 0; i < arrayLength; i++) {
            var y;
            var x;
            newArray[i] = y
            xArray[i] = x
        }
        var baseColor = "#{{ $general->base_color }}"
        var trace1 = {
            x: xArray,
            y: newArray,
            showlegend: true,
            line: {color: baseColor},
            visible: true,
            xaxis: 'x1',
            yaxis: 'y1',
        };
        var data = [trace1];
        var layout = {
            xaxis: {
                tickfont: {
                    size: 14,
                    color: '#fff'
                },
                ticklen: 8,
                tickwidth: 2,
                tickcolor: '#8f2331'
            },
            yaxis: {
                tickfont: {
                    size: 14,
                    color: '#fff'
                },
                ticklen: 8,
                tickwidth: 2,
                tickcolor: '#8f2331'
            },
            paper_bgcolor: '#141c24',
            plot_bgcolor: '#141c24',
            showlegend: false,
        };
        Plotly.plot('graph', {
            data: data,
            layout: layout
        });
        var inter = setInterval(function () {
            var dateTime = new Date();
            timezone = dateTime.getTimezoneOffset() / 60;
            gtime = dateTime.getHours() + ':' + dateTime.getMinutes() + ':' + dateTime.getSeconds();
            var time = dateTime.getHours() + ':' + dateTime.getMinutes() + ':' + dateTime.getSeconds();
            $.get("{{route('user.crypto.rate')}}", {coinSymbol: coinSymbol}, function (data) {
                $('#cryptoPrice').text(data);
                var y = data;
                var x = time;
                newArray = newArray.concat(y)
                newArray.splice(0, 1)
                xArray = xArray.concat(x)
                xArray.splice(0, 1)
            });

            var data_update = {
                x: [xArray],
                y: [newArray]
            };
            Plotly.update('graph', data_update)
        }, 1000);

        $(document).ready(function () {
            var gameLogId;
            var playTime;
            var playTimeUnit;
            var second;
            var highlowType;
            var coinId = "{{$currency->id}}";
            const highLowArray = [1, 2];
            const userBalance = {{ auth()->user()->demo_balance }};

            $(document).on('click', '.gameTime', function () {
                $(".highlight").children().removeClass('active');
                $(this).addClass('active');
                playTime = $(this).data('time');
                playTimeUnit = $(this).data('unit');
            });

            $(".highlowButton").on('click', function () {
                highlowType = $(this).val();
            })

            $("#playGame").on('submit', function (event) {
                event.preventDefault();
                var amount = $('input[name="amount"]').val();
                var timeCount = secondCount();

                if (!highLowArray.includes(parseInt(highlowType))) {
                    notify('error', 'Invalid Game Type');
                } else if (userBalance < amount) {
                    notify('error', 'Your Practice Balance {{ getAmount(auth()->user()->demo_balance) }} {{$general->cur_text}} Not Enough! Please Add Practice Amount');
                } else if (isNaN(amount) || amount <= 0) {
                    notify('error', 'Please Insert Valid Amount')
                } else if (isNaN(timeCount) || timeCount <= 0) {
                    notify('error', 'Please Select Valid Time')
                } else {
                    $('input[name="amount"]').val("");
                    $.ajax({
                        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                        url: "{{ route('user.demo.play.store') }}",
                        method: "POST",
                        data: {
                            amount: amount,
                            coinId: coinId,
                            highlowType: highlowType,
                            duration: playTime,
                            unit: playTimeUnit
                        },
                        success: function (response) {
                            if (response.value == 1) {
                                gameLogId = response.gameLogId;
                                countDown(timeCount, gameLogId)

                                if (highlowType == 1) {

                                    $(".trade-user-price").text("You Trade High. Price Was " + response.trade + " " + "USD");

                                    notify('success', 'Trade High');
                                } else {

                                    $(".trade-user-price").text("You Trade Low. Price Was " + response.trade + " " + "USD");

                                    notify('success', 'Trade Low');
                                }

                            } else if (response.value == 2) {
                                notify('error', response.message);
                            } else {
                                $.each(response, function (i, val) {
                                    notify('error', val)
                                });
                            }
                        }
                    });
                }
            });

            function secondCount() {
                if (playTimeUnit == 'seconds') {
                    second = playTime;
                    return second;
                } else if (playTimeUnit == 'minutes') {
                    second = playTime * 60;
                    return second;
                } else if (playTimeUnit == 'hours') {
                    second = playTime * 60 * 60;
                    return second;
                }
            }

            function countDown(timeCount, gameLogId) {
                var clock = $('.clock').FlipClock({
                    defaultClockFace: 'HourlyCounter',
                    autoStart: false,
                    callbacks: {
                        stop: function () {
                            gameResult(gameLogId)
                        }
                    }
                });
                clock.setTime(timeCount - 1);
                clock.setCountdown(true);
                clock.start();
            }

            function gameResult(gameLogId) {
                $.ajax({
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                    url: "{{ route('user.demo.game.result') }}",
                    method: "POST",
                    data: {gameLogId: gameLogId},
                    success: function (response) {
                        if (response == 1) {
                            notify('success', 'Trade Win');
                        } else if (response == 2) {
                            notify('error', 'Trade Lose');
                        } else if (response == 3) {
                            notify('error', 'Trade Draw');
                        } else {
                            $.each(response, function (i, val) {
                                notify('error', val)
                            });
                        }
                        setTimeout(function () {
                            location.reload();
                        }, 5000);
                    }
                });
            }
        });
    </script>
@endpush
