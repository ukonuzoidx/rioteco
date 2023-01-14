@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="deposit-preview bg--body">
                        <div class="deposit-thumb">
                            <img src="{{ $data->gateway_currency()->methodImage() }}" alt="@lang('Payment Image')">
                        </div>
                        <div class="deposit-content">
                            <ul>
                                <li>
                                    @lang('Amount'): <span class="text--success">{{getAmount($data->amount)}} {{__($general->cur_text)}}</span>
                                </li>
                                <li>
                                    @lang('Charge'): <span class="text--danger">{{getAmount($data->charge)}} {{__($general->cur_text)}}</span>
                                </li>
                                <li>
                                    @lang('Payable'): <span class="text--warning">{{getAmount($data->amount + $data->charge)}} {{__($general->cur_text)}}</span>
                                </li>
                                <li>
                                    @lang('Conversion Rate'): <span class="text--info">1 {{__($general->cur_text)}} = {{getAmount($data->rate)}}  {{__($data->baseCurrency())}}</span>
                                </li>
                                <li>
                                    @lang('In')  {{$data->baseCurrency()}}: <span class="text--primary">{{getAmount($data->final_amo)}}</span>
                                </li>
                                @if($data->gateway->crypto==1)
                                    <li>
                                        @lang('Conversion with')
                                        <b> {{ __($data->method_currency) }}</b> @lang('and final value will Show on next step')
                                    </li>
                                @endif
                            </ul>
                            @if( 1000 >$data->method_code)
                                <a href="{{route('user.deposit.confirm')}}" class="cmn--btn">@lang('Pay Now')</a>
                            @else
                                <a href="{{route('user.deposit.manual.confirm')}}" class="cmn--btn">@lang('Pay Now')</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


