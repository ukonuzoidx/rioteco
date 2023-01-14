@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="deposit-preview bg--body align-items-center">
                        <div class="deposit-thumb">
                            <img src="{{$deposit->gateway_currency()->methodImage()}}" alt="@lang('Payment Image')">
                        </div>
                        <div class="deposit-content justify-content-center">
                            <ul class="text-center pb-3">
                                <li>
                                    @lang('Final Amount'): <span class="text--success">{{getAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</span>
                                </li>
                                <li>
                                    @lang('To Get'): <span class="text--danger">{{getAmount($deposit->amount)}}  {{__($general->cur_text)}}</span>
                                </li>
                            </ul>
                            <button type="button" class="btn btn--success" id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                            <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                            <script>
                                var btn = document.querySelector("#btn-confirm");
                                btn.setAttribute("type", "button");
                                const API_publicKey = "{{$data->API_publicKey}}";

                                function payWithRave() {
                                    var x = getpaidSetup({
                                        PBFPubKey: API_publicKey,
                                        customer_email: "{{$data->customer_email}}",
                                        amount: "{{$data->amount }}",
                                        customer_phone: "{{$data->customer_phone}}",
                                        currency: "{{$data->currency}}",
                                        txref: "{{$data->txref}}",
                                        onclose: function () {
                                        },
                                        callback: function (response) {
                                            var txref = response.tx.txRef;
                                            var status = response.tx.status;
                                            var chargeResponse = response.tx.chargeResponseCode;
                                            if (chargeResponse == "00" || chargeResponse == "0") {
                                                window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                            } else {
                                                window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                            }
                                            
                                            }
                                        });
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection