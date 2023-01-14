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
                            <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                                @csrf
                                <button type="button" class="btn btn--success" id="btn-confirm">@lang('Pay Now')</button>
                                <script
                                    src="//js.paystack.co/v1/inline.js"
                                    data-key="{{ $data->key }}"
                                    data-email="{{ $data->email }}"
                                    data-amount="{{$data->amount}}"
                                    data-currency="{{$data->currency}}"
                                    data-ref="{{ $data->ref }}"
                                    data-custom-button="btn-confirm"
                                >
                                </script>
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

@endpush
