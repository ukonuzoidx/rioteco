@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-deposit text-center">
                            <div class="custom--card deposit--card">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('Payment Preview')</h3>
                                </div>
                            </div>
                            <div class="card-body card-body-deposit text-center">
                                <h4 class="my-2  text-info"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                                <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                                <img class="crypto-img" src="{{$data->img}}" alt="@lang('Image')">
                                <h4 class="text--danger bold my-4">@lang('SCAN TO SEND')</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
