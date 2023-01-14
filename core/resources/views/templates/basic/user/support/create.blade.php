@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="message__chatbox bg--body">
                <div class="message__chatbox__header">
                    <h5 class="title">@lang('Create New Ticket')</h5>
                    <a href="#0" class="cmn--btn btn--sm">@lang('All Ticket')</a>
                </div>
                <div class="message__chatbox__body">
                    <form class="message__chatbox__form row" action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    @csrf
                        <div class="form--group col-sm-6">
                            <label for="name" class="cmn--label">@lang('Name')</label>
                            <input type="text" id="name" name="name" class="form-control cmn--form--control bg--section" value="{{$user->fullname}}" readonly>
                        </div>
                        <div class="form--group col-sm-6">
                            <label for="email" class="cmn--label">@lang('Email')</label>
                            <input type="text" id="email" name="email" class="form-control cmn--form--control bg--section" value="{{$user->email}}" readonly>
                        </div>
                        <div class="form--group col-sm-12">
                            <label for="subject" class="cmn--label">@lang('Subject')</label>
                            <input type="text" id="subject" name="subject" class="form-control cmn--form--control bg--section" placeholder="@lang('Enter Subject')" required="">
                        </div>
                        <div class="form--group col-sm-12">
                            <label for="message" class="cmn--label">@lang('Message')</label>
                            <textarea id="message" name="message" class="form-control cmn--form--control bg--section" placeholder="@lang('Message')" required=""></textarea>
                        </div>

                        <div class="form--group col-sm-12">
                            <div class="d-flex">
                                <div class="left-group col p-0">
                                    <label for="file2" class="cmn--label">@lang('Attachments')</label>
                                    <input type="file"  class="overflow-hidden form-control cmn--form--control mb-2" name="attachments[]" id="file2">
                                    <div id="fileUploadsContainer"></div>
                                    <span class="info fs--14">@lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')</span>
                                </div>
                                <div class="add-area">
                                    <label class="cmn--label d-block">&nbsp;</label>
                                    <button class="cmn--btn btn--sm bg--primary ms-2 ms-md-4 cmn--form--control" onclick="extraTicketAttachment()" type="button"><i class="las la-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form--group col-sm-12 mb-0">
                            <button type="submit" class="cmn--btn">@lang('Send Message')</button>
                        </div>
                    </form> 
                </div>
            </div>
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
