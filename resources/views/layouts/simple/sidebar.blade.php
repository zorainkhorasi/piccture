<!--Main Sidebar Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true"
     data-img="assets/images/backgrounds/04.jpg">
    <div class="navbar-header" >
        <ul class="nav navbar-nav flex-row position-relative">
            <li class="nav-item mr-auto">
                <a class="navbar-brand text-info" href="">

                    {{config('global.project_shortname')}}
                </a>
            </li>
            <li class="nav-item d-none d-md-block nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="toggle-icon ft-disc font-medium-3" data-ticon="ft-disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="navigation-background"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

           @php
                $pages =app(\App\Http\Controllers\Settings\Menu::class)->dynamicMenu();
            @endphp

            @if(isset($pages) && $pages!='')
                @foreach($pages as $pk=>$pv)
                    @if($pv->isTitle==1)
                        <li class="sidebar-main-title">
                            <div>
                                <h6 class="lan-1">{{ trans('lang.'.$pv->langName) }} </h6>
                                <p class="lan-2">{{ trans('lang.'.$pv->titlePara) }}</p>
                            </div>
                        </li>
                    @elseif($pv->isParent==1)

                        @php
                            $url=request()->route()->getPrefix();
                        @endphp

                         <li class="nav-item mysettings"><a href="javascript:void(0)">
                                 <i data-feather="{{$pv->menuIcon}}"> </i><span class="menu-title" data-i18n="">{{ trans('lang.'.$pv->langName) }}</span></a>
                            <ul class="menu-content">
                                @if(isset($pv->myrow_options) && $pv->myrow_options!='')
                                    @foreach($pv->myrow_options as $ro)
                                        <li class="group_view {{ route::currentRouteName() == $ro->pageUrl ? 'active' : '' }}">
                                            <a
                                                href="{{ route($ro->pageUrl) }}"
                                                class="menu-item {{$ro->menuClass}} {{ route::currentRouteName() == $ro->pageUrl ? 'active' : '' }}"
                                                >{{ trans('lang.'.$ro->langName) }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @else
                        <li class=" nav-item {{ Route::currentRouteName()==$pv->pageUrl ? 'active' : '' }}">
                            <a
                                href="{{route($pv->pageUrl)}}"
                                class="{{ route::currentRouteName()==$pv->pageUrl ? 'active' : '' }}"
                            >
                                 <i data-feather="{{$pv->menuIcon}}"> </i>
                                 <span>{{ trans('lang.'.$pv->langName) }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>


</div>
<!--Main Sidebar Menu-->



