@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
		<div class="pb-120">
		    <div class="row justify-content-center g-4">
		        <div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="dashboard__item">
		                <div class="dashboard__thumb">
		                    <i class="las la-dollar-sign"></i>
		                </div>
		                <div class="dashboard__content">
		                    <h4 class="dashboard__title">{{$general->cur_sym}} {{getAmount($user->balance)}}</h4>
		                    <span class="subtitle">@lang('Current Balance')</span>
		                    <a href="{{route('user.withdraw.history')}}" class="btn btn--sm btn--primary">@lang('View All')</a>
		                </div>
		            </div>
		        </div>
		        <div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="dashboard__item">
		                <div class="dashboard__thumb">
		                    <i class="las la-wallet"></i>
		                </div>
		                <div class="dashboard__content">
		                    <h4 class="dashboard__title">{{$general->cur_sym}} {{getAmount($deposit)}}</h4>
		                    <span class="subtitle">@lang('Deposit')</span>
		                	<a href="{{route('user.deposit.history')}}" class="btn btn--sm btn--primary">@lang('View All')</a>
		                </div>
		            </div>
		        </div>
		        <div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="dashboard__item">
		                <div class="dashboard__thumb">
		                    <i class="las la-credit-card"></i>
		                </div>
		                <div class="dashboard__content">
		                    <h4 class="dashboard__title">{{$general->cur_sym}} {{getAmount($withdraw)}}</h4>
		                    <span class="subtitle">@lang('Withdraw')</span>
		                    <a href="{{route('user.withdraw.history')}}" class="btn btn--sm btn--primary">@lang('View All')</a>
		                </div>
		            </div>
		        </div>
		        <div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="dashboard__item">
		                <div class="dashboard__thumb">
		                    <i class="las la-money-bill"></i>
		                </div>
		                <div class="dashboard__content">
		                    <h4 class="dashboard__title">{{$transaction}}</h4>
		                    <span class="subtitle">@lang('Total Transactions')</span>
		                    <a href="{{route('user.transaction.log')}}" class="btn btn--sm btn--primary">@lang('View All')</a>
		                </div>
		            </div>
		        </div>
		        <div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="dashboard__item">
		                <div class="dashboard__thumb">
		                   <i class="las la-gamepad"></i>
		                </div>
		                <div class="dashboard__content">
		                    <h4 class="dashboard__title">{{$gameLog}}</h4>
		                    <span class="subtitle">@lang('Total Trade Log')</span>
		                    <a href="{{route('user.game.log')}}" class="btn btn--sm btn--primary">@lang('View All')</a>
		                </div>
		            </div>
		        </div>
		        <div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="dashboard__item">
		                <div class="dashboard__thumb">
		                    <i class="las la-trophy"></i>
		                </div>
		                <div class="dashboard__content">
		                    <h4 class="dashboard__title">{{$gameWin}}</h4>
		                    <span class="subtitle">@lang('Total Wining Trade')</span>
		                    <a href="{{route('user.wining.game.log')}}" class="btn btn--sm btn--primary">@lang('View All')</a>
		                </div>
		            </div>
		        </div>
		        <div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="dashboard__item">
		                <div class="dashboard__thumb">
		                    <i class="las la-slash"></i>
		                </div>
		                <div class="dashboard__content">
		                    <h4 class="dashboard__title">{{$gameLose}}</h4>
		                    <span class="subtitle">@lang('Total Losing Trade')</span>
		                    <a href="{{route('user.losing.game.log')}}" class="btn btn--sm btn--primary">@lang('View All')</a>
		                </div>
		            </div>
		        </div>
		        <div class="col-xl-3 col-lg-4 col-sm-6">
		            <div class="dashboard__item">
		                <div class="dashboard__thumb">
		                    <i class="las la-pencil-ruler"></i>
		                </div>
		                <div class="dashboard__content">
		                    <h4 class="dashboard__title">{{$gameDraw}}</h4>
		                    <span class="subtitle">@lang('Total Draw Trade')</span>
		                    <a href="{{route('user.draw.game.log')}}" class="btn btn--sm btn--primary">@lang('View All')</a>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="input-group mb-5">
		    <input type="text" name="key" value="{{ route('user.refer.register', auth::user()->username) }}" class="form-control h--50px cmn--form--control bg--section" id="referralURL" readonly>
		    <span class="input-group-text bg--info cmn--form--control h--50px cursor-pointer" onclick="myFunction()" id="copyBoard"> 
		        <i class="lar la-copy"></i> 
		    </span>                                      
		</div>

        <div class="pb-120">
            <div class="table-responsive">
                <table class="table cmn--table">
                    <thead>
                        <tr>
                            <th>@lang('Id')</th>
                            <th>@lang('Crypto Currency')</th>
                            <th>@lang('Crypto Symbol')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('High/Low')</th>
                            <th>@lang('Result')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($gamelogs as $gamelog)
                        <tr>
                            <td data-label="@lang('Id')">{{$loop->iteration}}</td>
                            <td data-label="@lang('Crypto Currency')">{{__($gamelog->crypto->name)}}</td>
                            <td data-label="@lang('Crypto Symbol')">{{__($gamelog->crypto->symbol)}}</td>
                            <td data-label="@lang('Amount')">{{getAmount($gamelog->amount)}} {{$general->cur_text}}</td>
                            <td data-label="@lang('High/Low')">
                                @if($gamelog->hilow == 1)
                                    <span class="badge badge--success">@lang('High')</span>
                                @elseif($gamelog->hilow == 2)
                                    <span class="badge badge--danger">@lang('Low')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Result')">
                                @if($gamelog->result == 1)
                                    <span class="badge badge--success">@lang('Win')</span>
                                @elseif($gamelog->result == 2)
                                    <span class="badge badge--danger">@lang('Lose')</span>
                                @elseif($gamelog->result == 3)
                                    <span class="badge badge--warning">@lang('Draw')</span>
                                @else
                                      <span class="badge badge--warning">@lang('Pending')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Status')">
                                @if($gamelog->status == 0)
                                    <span class="badge badge--primary">@lang('Running')</span>
                                @elseif($gamelog->status == 1)
                                    <span class="badge badge--success">@lang('Complete')</span>
                                @endif
                            </td>
                             <td data-label="@lang('Date')">{{showDateTime($gamelog->created_at,'d M, Y h:i:s')}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">@lang('No results found')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
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
            iziToast.success({message: "Referral Url Copied: " + copyText.value, position: "topRight"});
        }
    </script>
@endpush

