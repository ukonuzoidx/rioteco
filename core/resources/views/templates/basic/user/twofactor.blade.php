@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card custom--card h-100">
                        <div class="card-header">@lang('Two Factor Authenticator')
                        </div>
                        @if(Auth::user()->ts)
                            <div class="card-body">
                                <div class="two-factor-content">
                                    <div class="text-center">
                                       <a href="javascript:void(0)"class="cmn--btn btn--danger" data-bs-toggle="modal" data-bs-target="#disableModal">@lang('Disable Two Factor Authenticator')</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="two-factor-content">
                                    <div class="input-group">
                                        <input type="text" name="key" value="{{$secret}}" class="form-control h--50px cmn--form--control bg--section" id="referralURL" readonly>
                                        <span class="input-group-text bg--info cmn--form--control h--50px cursor-pointer" onclick="myFunction()" id="copyBoard"> 
                                            <i class="lar la-copy"></i> 
                                        </span>                                      
                                    </div>
                                    <div class="two-factor-scan text-center my-4">
                                        <img class="mw-100" src="{{$qrCodeUrl}}">
                                    </div>
                                    <div class="text-center">
                                        <a href="javascript:void(0)" class="cmn--btn" data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card custom--card h-100">
                        <div class="card-header">
                            @lang('Google Authenticator')
                        </div>
                        <div class="card-body">
                            <div class="two-factor-content">
                                <p class="two__fact__text">
                                    @lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')
                                </p>
                                <a class="cmn--btn" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('DOWNLOAD APP')</a>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
           

 <!-- Enable Modal -->
<div class="modal fade custom--modal" id="enableModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Verify Your Otp')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form class="deposit-form" action="{{route('user.twofactor.enable')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="cmn--form--group form-group">
                        <input type="hidden" name="key" value="{{$secret}}">
                        <input type="text" class="form-control cmn--form--control"name="code" placeholder="@lang('Enter Google Authenticator Code')" required="">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="cmn--btn btn--sm text--white btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="cmn--btn btn--sm text--white btn--success">@lang('Verify')</button>
                </div>
            </form>
        </div>
    </div>
</div>


 <!-- Disable Modal -->
<div class="modal fade custom--modal" id="disableModal">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Verify Your Otp Disable')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form class="deposit-form" action="{{route('user.twofactor.disable')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="cmn--form--group form-group">
                        <input type="text" class="form-control cmn--form--control"name="code" placeholder="@lang('Enter Google Authenticator Code')" required="">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="cmn--btn btn--sm text--white btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="cmn--btn btn--sm text--white btn--success">@lang('Verify')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        "use strict";
        function myFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush


