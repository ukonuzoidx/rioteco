@extends($activeTemplate.'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="message__chatbox bg--body">
                <div class="message__chatbox__header">
                    <h5 class="title">
                     @if($my_ticket->status == 0)
                        <span class="badge badge--success">@lang('Open')</span>
                    @elseif($my_ticket->status == 1)
                        <span class="badge badge--primary">@lang('Answered')</span>
                    @elseif($my_ticket->status == 2)
                        <span class="badge badge--warning">@lang('Replied')</span>
                    @elseif($my_ticket->status == 3)
                        <span class="badge badge--danger">@lang('Closed')</span>
                    @endif
                    <span class="text-white">[@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}</span></h5>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#DelModal" class="btn--sm d-block cmn--btn btn--danger text-center">@lang('Close Ticket')</a>
                </div>
                <div class="message__chatbox__body">
                @if($my_ticket->status != 4)
                    <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" class="message__chatbox__form row" enctype="multipart/form-data">
                        @csrf
                        <div class="form--group col-sm-12">
                            <textarea id="message" name="message" class="form-control cmn--form--control" placeholder="@lang('Enter Message')" required=""></textarea>
                        </div>
                        <div class="form--group col-sm-12">
                            <div class="d-flex">
                                <div class="left-group col p-0">
                                    <label for="file" class="cmn--label">@lang('Attachments')</label>
                                    <input type="file" class="overflow-hidden form-control cmn--form--control mb-2" id="file" name="attachments[]">
                                    <div id="fileUploadsContainer"></div>
                                    <span class="info fs--14">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')</span>
                                </div>
                                <div class="add-area">
                                    <label class="cmn--label d-block">&nbsp;</label>
                                    <button class="cmn--btn btn--sm bg--primary cmn--form--control ms-2 ms-md-4"  onclick="extraTicketAttachment()" type="button"><i class="las la-plus"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="form--group col-sm-12 mt-2 mb-0">
                            <button type="submit" class="cmn--btn" name="replayTicket" value="1">@lang('Send Message')</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <div class="pb-120">
            <div class="message__chatbox bg--body">
                <div class="message__chatbox__body">
                    <ul class="reply-message-area">
                    @foreach($messages as $message)
                            <li>
                        @if($message->admin_id == 0)
                                <div class="reply-item">
                                    <div class="name-area">
                                        <h6 class="title">{{__($message->ticket->name)}}</h6>
                                    </div>
                                    <div class="content-area">
                                        <span class="meta-date">
                                            @lang('Posted on') <span class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                        </span>
                                        <p>
                                            {{__($message->message)}}
                                        </p>
                                         @if($message->attachments()->count() > 0)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $k=> $image)
                                                    <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <ul>
                                    <li>
                                        <div class="reply-item">
                                            <div class="name-area">
                                                <div class="reply-thumb">
                                                    <img src="{{getImage('assets/admin/images/profile/'. $message->admin->image, '400x400')}}" alt="@lang('Admin Image')">
                                                </div>
                                                <h6 class="title">{{__($message->admin->name)}}</h6>
                                            </div>
                                            <div class="content-area">
                                                <span class="meta-date">
                                                    @lang('Posted on'), <span class="cl-theme">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span>
                                                </span>
                                                <p>
                                                    {{__($message->message)}}
                                                </p>
                                                @if($message->attachments()->count() > 0)
                                                    <div class="mt-2">
                                                        @foreach($message->attachments as $k=> $image)
                                                            <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            @endif
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

            
    
    <div class="modal fade custom--modal" id="DelModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">@lang('Confirmation')</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form class="deposit-form" method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to close this support ticket')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn--btn btn--sm text--white btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="cmn--btn btn--sm text--white btn--success" name="replayTicket" value="2">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        function extraTicketAttachment() {
            $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="overflow-hidden form-control cmn--form--control mb-2" required />')
        }
    </script>
@endpush
