@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="row g-4">
                @foreach($withdrawMethod as $data)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="card custom--card deposit--card">
                            <div class="card-header">
                                <h5 class="card-title">{{__($data->name)}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="deposit__thumb">
                                    <img src="{{getImage(imagePath()['withdraw']['method']['path'].'/'. $data->image,imagePath()['withdraw']['method']['size'])}}" alt="{{__($data->name)}}">
                                </div>
                                <ul class="list-group text-center list--group">
                                    <li class="list-group-item">@lang('Limit')
                                        : {{getAmount($data->min_limit)}}
                                        - {{getAmount($data->max_limit)}} {{__($general->cur_text)}}</li>

                                    <li class="list-group-item"> @lang('Charge')
                                        - {{getAmount($data->fixed_charge)}} {{__($general->cur_text)}}
                                        + {{getAmount($data->percent_charge)}}%
                                    </li>
                                    <li class="list-group-item">@lang('Processing Time')
                                        - {{$data->delay}}
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer text-center">
                                <a href="javascript:void(0)"  data-id="{{$data->id}}"
                                   data-resource="{{$data}}"
                                   data-min_amount="{{getAmount($data->min_limit)}}"
                                   data-max_amount="{{getAmount($data->max_limit)}}"
                                   data-fix_charge="{{getAmount($data->fixed_charge)}}"
                                   data-percent_charge="{{getAmount($data->percent_charge)}}"
                                   data-base_symbol="{{__($general->cur_text)}}"
                                   class="btn btn-block btn--success deposit" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    @lang('Withdraw Now')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


    <div class="modal fade custom--modal" id="exampleModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title method-name"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('user.withdraw.money')}}" method="POST">
                    @csrf
                    <input type="hidden" name="currency"  class="edit-currency form-control" value="">
                    <input type="hidden" name="method_code" class="edit-method-code  form-control" value="">
                      
                    <div class="modal-body">
                        <p class="text-danger depositLimit"></p>
                        <p class="text-danger depositCharge"></p>
                        
                        <div class="form-group">
                            <label>@lang('Enter Amount'):</label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control cmn--form--control" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}">
                                <span class="input-group-text bg--info px-3 cmn--form--control">{{__($general->cur_text)}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="cmn--btn btn--sm text--white btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="cmn--btn btn--sm text--white btn--success">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        "use strict";
        $(document).ready(function(){
            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var result = $(this).data('resource');
                var minAmount = $(this).data('min_amount');
                var maxAmount = $(this).data('max_amount');
                var fixCharge = $(this).data('fix_charge');
                var percentCharge = $(this).data('percent_charge');

                var depositLimit = `@lang('Withdraw Limit'): ${minAmount} - ${maxAmount}  {{__($general->cur_text)}}`;
                $('.depositLimit').text(depositLimit);
                var depositCharge = `@lang('Charge'): ${fixCharge} {{__($general->cur_text)}} ${(0 < percentCharge) ? ' + ' + percentCharge + ' %' : ''}`
                $('.depositCharge').text(depositCharge);
                $('.method-name').text(`@lang('Withdraw Via') ${result.name}`);
                $('.edit-currency').val(result.currency);
                $('.edit-method-code').val(result.id);
            });


        });
    </script>

@endpush

