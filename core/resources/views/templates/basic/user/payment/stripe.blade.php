@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card custom--card">
                        <div class="card-header">@lang('Stripe Payment')</div>
                        <div class="card-body card-body-deposit">
                            <div class="card-wrapper"></div>
                            <br><br>
                            <form role="form" id="payment-form" method="{{$data->method}}" action="{{$data->url}}">
                                {{csrf_field()}}
                                <input type="hidden" value="{{$data->track}}" name="track">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">@lang('CARD NAME')</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control cmn--form--control custom-input" name="name" placeholder="@lang('Card Name')" autocomplete="off" autofocus/>
                                            <span class="input-group-text bg--info px-3 cmn--form--control"><i class="las la-id-card"></i></span>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="cardNumber">@lang('CARD NUMBER')</label>
                                        <div class="input-group">
                                            <input type="tel" class="form-control cmn--form--control custom-input" name="cardNumber" placeholder="@lang('Valid Card Number')" autocomplete="off" required autofocus/>
                                            <span class="input-group-text bg--info px-3 cmn--form--control"><i class="las la-credit-card"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <label for="cardExpiry">@lang('EXPIRATION DATE')</label>
                                        <input type="tel" class="form-control cmn--form--control input-sz custom-input" name="cardExpiry" placeholder="@lang('MM / YYYY')" autocomplete="off" required/>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="cardCVC">@lang('CVC CODE')</label>
                                        <input type="tel" class="form-control cmn--form--control input-sz custom-input" name="cardCVC" placeholder="@lang('CVC')" autocomplete="off" required/>
                                    </div>
                                </div>
                                <br>
                                <button class="cmn--btn text--white" type="submit"> @lang('PAY NOW')
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script type="text/javascript" src="https://rawgit.com/jessepollak/card/master/dist/card.js"></script>

    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                var card = new Card({
                    form: '#payment-form',
                    container: '.card-wrapper',
                    formSelectors: {
                        numberInput: 'input[name="cardNumber"]',
                        expiryInput: 'input[name="cardExpiry"]',
                        cvcInput: 'input[name="cardCVC"]',
                        nameInput: 'input[name="name"]'
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
