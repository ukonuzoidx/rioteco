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
                        @forelse($practices as $practice)
                            <tr>
                                <td data-label="@lang("Id")">{{$loop->iteration}}</td>
                                <td data-label="@lang("Crypto Currency")">{{__($practice->crypto->name)}}</td>
                                <td data-label="@lang("Crypto Symbol")">{{__($practice->crypto->symbol)}}</td>
                                <td data-label="@lang("Amount")">{{getAmount($practice->amount)}} {{$general->cur_text}}</td>
                                <td data-label="@lang("High/Low")">
                                    @if($practice->hilow == 1)
                                        <span class="badge badge--success">@lang('High')</span>
                                    @elseif($practice->hilow == 2)
                                        <span class="badge badge--danger">@lang('Low')</span>
                                    @endif
                                </td>
                                <td data-label="@lang("Result")">
                                    @if($practice->result == 1)
                                        <span class="badge badge--success">@lang('Win')</span>
                                    @elseif($practice->result == 2)
                                        <span class="badge badge--danger">@lang('Lose')</span>
                                    @elseif($practice->result == 3)
                                        <span class="badge badge--warning">@lang('Draw')</span>
                                    @else
                                          <span class="badge badge--warning">@lang('Pending')</span>
                                    @endif
                                </td>
                                <td data-label="@lang("Status")">
                                    @if($practice->status == 0)
                                        <span class="badge badge--primary">@lang('Running')</span>
                                    @elseif($practice->status == 1)
                                        <span class="badge badge--success">@lang('Complete')</span>
                                    @endif
                                </td>
                                 <td data-label="@lang("Date")">{{showDateTime($practice->created_at, 'd M, Y h:i:s')}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%"> @lang('No results found')!</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
           {{paginateLinks($practices) }}
        </div>
    </div>
</div>
@endsection