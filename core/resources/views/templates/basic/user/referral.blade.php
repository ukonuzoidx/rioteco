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
                            <th>@lang('ID')</th>
                            <th>@lang('First Name')</th>
                            <th>@lang('Last Name')</th>
                            <th>@lang('Username')</th>
                            <th>@lang('Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($referrals as $referral)
                            <tr>
                                <td data-label="@lang('ID')">{{$loop->iteration}}</td>
                                <td data-label="@lang('First Name')">{{__($referral->firstname)}}</td>
                                <td data-label="@lang('Last Name')">{{__($referral->lastname)}}</td>
                                <td data-label="@lang('Username')"> {{__($referral->username)}}</td>
                                <td data-label="@lang('Date')">{{ showDateTime($referral->created_at) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{paginateLinks($referrals) }}
        </div>
    </div>
</div>
@endsection



