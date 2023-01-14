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
                            <th>@lang('TRX')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Charge')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Detail')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                            <tr>
                                <td data-label="@lang('Date')">{{ showDateTime($trx->created_at) }}</td>
                                <td data-label="@lang('TRX')" class="font-weight-bold">{{ $trx->trx }}</td>
                                <td data-label="@lang('Amount')" class="budget">
                                    <strong @if($trx->trx_type == '+') class="text-success" @else class="text-danger" @endif> {{($trx->trx_type == '+') ? '+':'-'}} {{getAmount($trx->amount)}} {{__($general->cur_text)}}</strong>
                                </td>
                                <td data-label="@lang('Charge')" class="budget">{{ __(__($general->cur_sym)) }} {{ getAmount($trx->charge) }} </td>
                                <td data-label="@lang('Post Balance')">{{ getAmount($trx->post_balance) }} {{__($general->cur_text)}}</td>
                                <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($empty_message) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{paginateLinks($transactions) }}
        </div>
    </div>
</div>
@endsection



