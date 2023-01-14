@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
        
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-3">
                <a href="javascript:void(0)" class="cmn--btn my-2" data-bs-toggle="modal" data-bs-target="#practiceAmount"><i class="las la-plus"></i> @lang('Add Practice Balance')</a>
                <h6 class="my-2">@lang('Practice Balance') : {{getAmount(auth()->user()->demo_balance)}} {{$general->cur_text}}</h6>
            </div>
          
            <div class="row g-4">
                @foreach($cryptos as $crypto)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="card custom--card deposit--card">
                            <div class="card-header">
                                <h5 class="card-title">{{__($crypto->name)}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="deposit__thumb">
                                    <a href="{{route('user.demo.play.game', $crypto->name)}}"><img src="{{getImage('assets/images/cryptoCurrency/'. $crypto->image, '800x800')}}" alt="{{__($crypto->name)}}"></a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('user.demo.play.game', $crypto->name)}}" class="btn--sm d-block cmn--btn text-center">
                                @lang('Trade Now')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom--modal" id="practiceAmount">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">@lang('Add Practice Balance')</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form class="deposit-form" action="{{route('user.add.practice.balance')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>@lang('Are you sure you want to add practice balance')?</p>
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

