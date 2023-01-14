@extends($activeTemplate.'layouts.user')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<div class="dashboard-section pt-120 bg--section">
    <div class="container">
        <div class="pb-120">
            <div class="profile-wrapper bg--body">
                <div class="profile-user mb-lg-0">
                    <div class="thumb">
                        <img src="{{getImage('assets/images/user/profile/'.auth()->user()->image, '400x400')}}" alt="@lang('user')">
                    </div>
                    <div class="content">
                        <h6 class="title m-1">@lang('Email'): {{__($user->email)}}</h6>
                        <h6 class="title m-1">@lang('Username'): {{$user->username}}</h6>
                        <h6 class="title m-1">@lang('Phone Number'): {{$user->mobile}}</h6>
                        <h6 class="title m-1">@lang('Country'): {{$user->address->country}}</h6>
                    </div>
                </div>
                <div class="profile-form-area">
                    <form class="profile-edit-form row mb--25" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form--group col-md-6">
                            <label class="cmn--label" for="first-name">@lang('First Name')</label>
                            <input type="text" class="form-control cmn--form--control" name="firstname" id="first-name" value="{{$user->firstname}}" required="">
                        </div>
                        <div class="form--group col-md-6">
                            <label class="cmn--label" for="last-name">@lang('Last Name')</label>
                            <input type="text" class="form-control cmn--form--control" name="lastname" id="last-name" value="{{$user->lastname}}" required="">
                        </div>

                         <div class="form--group">
                            <label class="cmn--label" for="address">@lang('Address')</label>
                            <input type="text" class="form-control cmn--form--control" name="address" id="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required="">
                        </div>
                
                        <div class="form--group col-md-6">
                            <label class="cmn--label" for="city">@lang('City')</label>
                            <input type="text" class="form-control cmn--form--control" name="city" id="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required="">
                        </div>
                       
                        <div class="form--group col-md-6">
                            <label class="cmn--label" for="state">@lang('State')</label>
                            <input type="text" class="form-control cmn--form--control" name="state" id="state" value="{{@$user->address->state}}" required="" placeholder="@lang('State')">
                        </div>
                        <div class="form--group col-md-6">
                            <label class="cmn--label" for="zip">@lang('Zip')</label>
                            <input type="text" class="form-control cmn--form--control" name="zip" id="zip" value="{{@$user->address->zip}}" required="" placeholder="@lang('Zip')">
                        </div>
                        <div class="form--group col-md-6">
                            <label class="cmn--label" for="profile-image">@lang('Change Profile Picture')</label>
                            <input type="file" class="form-control cmn--form--control" name="image" id="profile-image">
                        </div>
                        <div class="form--group w-100 col-md-6 mb-0 text-end">
                            <button type="submit" class="cmn--btn">@lang('Update Profile')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
