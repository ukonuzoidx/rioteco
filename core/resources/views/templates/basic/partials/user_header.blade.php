
    <header class="header-section">
        <div class="header-top bg--section">
            <div class="container">
                <ul class="header-top-area">
                    <li class="me-auto">
                        <div class="select-bar">
                            <select class="langSel">
                                @foreach($language as $item)
                                    <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                    <li class="dashboard-dashboard-icon">
                        <div class="avatar">
                            <img src="{{getImage('assets/images/user/profile/'.auth()->user()->image)}}" alt="@lang('UserImage')">
                        </div>
                        <ul class="dashboard-menu">
                             <li>
                                <a href="{{route('ticket')}}">@lang('Get Support')</a>
                            </li>
                            <li>
                                <a href="{{route('user.profile-setting')}}">@lang('Profile Setting')</a>
                            </li>
                            <li>
                                <a href="{{route('user.change-password')}}">@lang('Change Password')</a>
                            </li>
                            <li>
                                <a href="{{route('user.twofactor')}}">@lang('2FA Security')</a>
                            </li>
                            <li>
                                <a href="{{route('user.logout')}}">@lang('Logout')</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="header-wrapper">
                    <div class="logo">
                        <a href="{{route('home')}}"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="@lang('logo')"></a>
                    </div>
                    <ul class="menu">
                        <li>
                            <a href="{{route('user.home')}}">@lang('Dashboard')</a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">@lang('Practice')</a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{route('user.demo.play')}}">@lang('Practice Now')</a>
                                </li>
                                <li>
                                    <a href="{{route('user.practice.trade.log')}}">@lang('Practice Log')</a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a href="javascript:void(0)">@lang('Trade')</a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{route('user.play.now')}}">@lang('Trade Now')</a>
                                </li>
                                <li>
                                    <a href="{{route('user.game.log')}}">@lang('Trade Log')</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0)">@lang('Deposit')</a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{route('user.deposit')}}">@lang('Deposit Money')</a>
                                </li>
                                <li>
                                    <a href="{{route('user.deposit.history')}}">@lang('Deposit History')</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0)">@lang('Withdraw')</a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{route('user.withdraw')}}">@lang('Withdraw Money')</a>
                                </li>
                                <li>
                                    <a href="{{route('user.withdraw.history')}}">@lang('Withdraw History')</a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a href="javascript:void(0)">@lang('Referral')</a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{route('user.referralog.log')}}">@lang('Referral Log')</a>
                                </li>

                                <li>
                                    <a href="{{route('user.commissions.log')}}">@lang('Commission Log')</a>
                                </li>
                            </ul>
                        </li>

                         <li>
                            <a href="{{route('user.transaction.log')}}">@lang('Transaction Log')</a>
                        </li>
                    </ul>
                    <div class="header-bar m-0">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
