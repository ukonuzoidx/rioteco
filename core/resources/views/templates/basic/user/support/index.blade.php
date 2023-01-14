@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class=" my-2 text-end">
                <a href="{{route('ticket.open')}}" class="cmn--btn btn--sm">@lang('New Ticket')</a>
            </div>
            <div class="table-responsive">
                <table class="table cmn--table">
                    <thead>
                        <tr>
                            <th>@lang('Subject')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Last Reply')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supports as $key => $support)
                            <tr>
                                <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold">[@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                <td data-label="@lang('Status')">
                                    @if($support->status == 0)
                                        <span class="badge badge--success">@lang('Open')</span>
                                    @elseif($support->status == 1)
                                        <span class="badge badge--primary">@lang('Answered')</span>
                                    @elseif($support->status == 2)
                                        <span class="badge badge--warning">@lang('Customer Reply')</span>
                                    @elseif($support->status == 3)
                                        <span class="badge badge--danger">@lang('Closed')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--primary btn-sm">
                                        <i class="las la-desktop"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%"> @lang('No results found')!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{paginateLinks($supports) }}
        </div>
    </div>
</div>
@endsection
