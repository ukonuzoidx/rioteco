@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="table-responsive">
                <table class="table cmn--table">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Username')</th>
                            <th>@lang('TRX')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Detail')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commissions as $commission)
                            <tr>
                                <td data-label="@lang('Date')">{{ showDateTime($commission->created_at) }}</td>
                                <td data-label="@lang('Username')">{{$commission->fromUser->username}}</td>
                                <td data-label="@lang('TRX')" class="font-weight-bold">{{ $commission->trx }}</td>
                                <td data-label="@lang('Amount')">{{getAmount($commission->amount)}} {{__($general->cur_text)}}</td>
                                <td data-label="@lang('Post Balance')">{{ getAmount($commission->post_balance) }} {{__($general->cur_text)}}</td>
                                <td data-label="@lang('Detail')">{{ __($commission->details) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{paginateLinks($commissions) }}
        </div>
    </div>
</div>
@endsection



