@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="row g-4">
                @foreach($cryptos as $crypto)
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="card custom--card deposit--card">
                            <div class="card-header">
                                <h5 class="card-title">{{__($crypto->name)}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="deposit__thumb">
                                    <a href="{{route('user.play.game', $crypto->name)}}"><img src="{{getImage('assets/images/cryptoCurrency/'. $crypto->image, '800x800')}}" alt="{{__($crypto->name)}}"></a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('user.play.game', $crypto->name)}}" class="btn--sm d-block cmn--btn text-center">
                                @lang('Trade Now')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

