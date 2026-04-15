<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="collapse navbar-collapse show" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i
                                    class="ficon ft-maximize"></i></a></li>
                    <li class="dropdown nav-item mega-dropdown d-none d-md-block">

                    </li>
                    <li class="nav-item dropdown navbar-search"><a class="nav-link dropdown-toggle hide"
                                                                   data-toggle="dropdown" href="#"><i
                                    class="ficon ft-search"></i></a>
                        <ul class="dropdown-menu">
                            <li class="arrow_box">
                                <form>
                                    <div class="input-group search-box">
                                        <div class="position-relative has-icon-right full-width">
                                            <input class="form-control" id="search" type="text"
                                                   placeholder="Search here...">
                                            <div class="form-control-position navbar-search-close"><i class="ft-x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    @php
                        $notiCnt=0;
                        $notiList='';
                        $pwdExpiry = Auth::user()->pwdExpiry;
                        if(1==1){
                            $notiCnt=1;

                            $notiList.='<a href="javascript:void(0)" onclick="showFirstPwdModal(2)">
                                        <div class="media">
                                            <!-- <div class="media-left align-self-center">
                                                <i class="fa fa-circle-o me-3 font-primary"></i>
                                                <strong>Password Expiring: </strong>
                                            </div> -->
                                            <div class="media-body text-danger">
                                                <b>Password Expiring:<b><br/>
                                                     <i class="fa fa-circle-o me-3 r"></i>
                                                    <span class="">Your password is expiring on </span>
                                                        '.date('Y-m-d', strtotime($pwdExpiry)).'
                                            </div>
                                        </div>
                                    </a>';
                        }
                        else{
                            $notiList.='<a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                        class="ft-share info font-medium-4 mt-2"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading info">No new notification</h6>
                                            </div>
                                        </div>
                                    </a>';
                            }
                    @endphp
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false">
                            <i class="ficon ft-bell bell-shake" id="notification-navbar-link"></i>
                            <span class="badge badge-pill badge-sm badge-danger badge-up badge-glow"><?php echo $notiCnt;?></span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <div class="arrow_box_right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span>
                                    </h6>
                                </li>
                                <li class="scrollable-container media-list w-100 ps">
                                    <?php echo $notiList; ?>
                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                    </div>
                                </li>

                            </div>
                        </ul>
                    </li>

                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link"
                           href="javascript:void(0)" data-toggle="dropdown">
                            <span class="avatar avatar-online">
                                <img src="{{asset(config('global.asset_path_bnp').'/assets/images/user.png')}}" alt="avatar"><i></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="arrow_box_right">
                                <a class="dropdown-item" href="">
                                    <span class="avatar avatar-online">
                                          <img src="{{asset(config('global.asset_path_bnp').'/assets/images/user.png')}}" alt="avatar">
                                        <span class="user-name text-bold-100">
                                            {{ Auth::user()->name }}
                                        </span>
                                    </span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0)"
                                    onclick="showFirstPwdModal(2);">
                                    <i class="ft-settings"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <form id="logout-form" class="dropdown-item" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                   <i data-feather="log-in"></i>{{ __('LogOut') }}
                                </button>


                            </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
