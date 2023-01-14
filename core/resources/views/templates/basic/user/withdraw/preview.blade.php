@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="withdraw-preview bg--body">
                        <div class="w-100 preview-header">
                            <h5 class="m-0">@lang('Current Balance') <span class="text--base">{{ getAmount(auth()->user()->balance)}}  {{ __($general->cur_text) }}</span></h5>
                        </div>
                        <div class="withdraw-content">
                            <ul>
                                <li>
                                    @lang('Request Amount'): <span class="text--success">{{getAmount($withdraw->amount)  }} {{__($general->cur_text)}}</span>
                                </li>
                                <li>
                                    @lang('Withdrawal Charge'): <span class="text--danger">{{getAmount($withdraw->charge) }} {{__($general->cur_text)}}</span>
                                </li>

                                <li>
                                    @lang('Payable'): <span class="text--danger">{{getAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</span>
                                </li>

                                <li>
                                    @lang('Conversion Rate'): <span class="text--info">1 {{__($general->cur_text)}} = {{getAmount($withdraw->rate)  }} {{__($withdraw->currency)}}</span>
                                </li>
                                <li>
                                    @lang('You Will Get') : <span class="text--primary">{{getAmount($withdraw->final_amount) }} {{__($withdraw->currency)}}</span>
                                </li>
                            </ul>
                            <h6 class="subtitle mt-4 mb-2">@lang('Balance Will be')</h6>
                            <div class="input-group">
                                <input type="text" value="{{getAmount($withdraw->user->balance - ($withdraw->amount))}}" class="form-control h--50px cmn--form--control" placeholder="Enter Amount" required="" readonly="">
                                <span class="input-group-text bg--info cmn--form--control h--50px">
                                   {{$general->cur_text}}
                                </span>                                           
                            </div>
                        </div>
                        <div class="withdraw-form-area">
                        <form class="withdraw-form" action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if($withdraw->method->user_data)
                            @foreach($withdraw->method->user_data as $k => $v)
                                @if($v->type == "text")
                                    <div class="form-group">
                                        <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                        <input type="text" name="{{$k}}" class="form-control cmn--form--control h--50px" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                                        @if ($errors->has($k))
                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                        @endif
                                    </div>
                                @elseif($v->type == "textarea")
                                    <div class="form-group">
                                        <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                        <textarea name="{{$k}}"  class="form-control cmn--form--control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                        @if ($errors->has($k))
                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                        @endif
                                    </div>
                                @elseif($v->type == "file")
                                    <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new " data-provides="fileinput">
                                            <div class="fileinput-new thumbnail withdraw-thumbnail"
                                                 data-trigger="fileinput">
                                                <img class="w-100" src="{{ getImage('/')}}" alt="@lang('Image')">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>
                                            <div class="img-input-div">
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new text-white"> @lang('Select') {{__($v->field_level)}}</span>
                                                    <span class="fileinput-exists text-white"> @lang('Change')</span>
                                                    <input type="file" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>
                                                </span>
                                                <a href="#" class="btn btn-danger fileinput-exists"
                                                data-dismiss="fileinput"> @lang('Remove')</a>
                                            </div>
                                        </div>
                                        @if ($errors->has($k))
                                            <br>
                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                            @endif
                            <div class="form-group">
                                <button type="submit" class="cmn--btn btn-block my-3">@lang('Confirm')</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style-lib')
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-fileinput.css')}}">
@endpush
@push('script-lib')
    <script src="{{asset('assets/js/bootstrap-fileinput.js')}}"></script>
@endpush

