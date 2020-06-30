
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand  pt-0 pb-0 mt-3" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('assets') }}/img/logo/logo.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('assets') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('admin.dashboard') }}">
                            <img src="{{ asset('assets') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    {{-- (strpos(Route::currentRouteName(), 'admin.cities') == 0) ? 'active' : '' --}}
                    <a class="nav-link {{ (strpos(Route::currentRouteName(), 'dashboard') != 0) ? 'active' : '' }} " href=" {{ route('admin.dashboard') }} ">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                {{-- usermanagement --}}
                @if(Auth::user()->hasAnyPermission(['role-list', 'permission-list', 'user-list']))
                    <li class="nav-item ">
                        <a class="nav-link {{ (strpos(Route::currentRouteName(), 'user_management') != 0) ? 'active' : '' }}" href="#navbar-user-management" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-user-management">
                            <i class="fab fa-laravel" ></i>
                            <span class="nav-link-text" >User Management</span>
                        </a>

                        <div class="collapse {{ (strpos(Route::currentRouteName(), 'user_management') != 0) ? 'show' : '' }}" id="navbar-user-management">
                            <ul class="nav nav-sm flex-column">
                                {{-- role --}}
                                @can('permission-list')
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'permission') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.user_management.permission.index') }}">
                                            List Permission
                                        </a>
                                    </li>    
                                @endcan
                                @can('role-list')
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'role') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.user_management.role.index') }}">
                                            List Role
                                        </a>
                                    </li>    
                                @endcan
                                @can('user-list')
                                    <li class="nav-item" {{ (strpos(Route::currentRouteName(), 'user') != 0) ? 'active' : '' }}>
                                        <a class="nav-link" href="{{ route('admin.user_management.user.index') }}">
                                            List User
                                        </a>
                                    </li>                          
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- master data --}}
                {{-- @if (Auth::user()->hasAnyPermission(['udd-list']))     --}}
                    {{-- @can('udd-list')     --}}
                        <li class="nav-item ">
                            <a class="nav-link {{ (strpos(Route::currentRouteName(), 'master') != 0) ? 'active' : '' }}" href="#navbar-master" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-master">
                                <i class="fab fa-laravel" ></i>
                                <span class="nav-link-text" >Master</span>
                            </a>

                            <div class="collapse {{ (strpos(Route::currentRouteName(), 'master') != 0) ? 'show' : '' }}" id="navbar-master">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'udd') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.master.udd.index') }}">
                                            UDD PMI
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'jenis_donor') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.master.jenis_donor.index') }}">
                                            Jenis Donor
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'news_category') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.master.news_category.index') }}">
                                            News Category
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'golongan_darah') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.master.golongan_darah.index') }}">
                                            Golongan Darah
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'produk_darah') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.master.produk_darah.index') }}">
                                            Produk Darah
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'user_driver') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.master.user_driver.index') }}">
                                            User Driver
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'rumah_sakit') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.master.rumah_sakit.index') }}">
                                            Rumah Sakit
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    {{-- @endcan --}}
                {{-- @endif --}}

                {{-- anamnesa --}}
                        <li class="nav-item ">
                            <a class="nav-link {{ (strpos(Route::currentRouteName(), 'anamnesa') != 0) ? 'active' : '' }}" href="#navbar-anamnesa" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-anamnesa">
                                <i class="fab fa-laravel" ></i>
                                <span class="nav-link-text" >Anamnesa</span>
                            </a>

                            <div class="collapse {{ (strpos(Route::currentRouteName(), 'anamnesa') != 0) ? 'show' : '' }}" id="navbar-anamnesa">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'kategori_anamnesa') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.anamnesa.kategori_anamnesa.index') }}">
                                            Kategori Anamnesa
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'tipe_anamnesa') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.anamnesa.tipe_anamnesa.index') }}">
                                            Tipe Anamnesa
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'pertanyaan_anamnesa') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.anamnesa.pertanyaan_anamnesa.index') }}">
                                            Pertanyaan Anamnesa
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'persetujuan_anamnesa') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.anamnesa.persetujuan_anamnesa.index') }}">
                                            Persetujuan Anamnesa
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                {{-- data --}}
                {{-- @if (Auth::user()->hasAnyPermission(['udd-list']))     --}}
                    {{-- @can('udd-list')     --}}
                        <li class="nav-item ">
                            <a class="nav-link {{ (strpos(Route::currentRouteName(), 'data') != 0) ? 'active' : '' }}" href="#navbar-data" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-data">
                                <i class="fa fa-folder" ></i>
                                <span class="nav-link-text" >Data</span>
                            </a>
    
                            <div class="collapse {{ (strpos(Route::currentRouteName(), 'data') != 0) ? 'show' : '' }}" id="navbar-data">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'news') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.data.news.index') }}">
                                            <i class="fa fa-list" ></i>
                                            News
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'kegiatan') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.data.kegiatan.index') }}">
                                            <i class="fa fa-calendar" ></i>
                                            Kegiatan
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'stock_darah') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.data.stock_darah.index') }}">
                                            <i class="fa fa-heart" ></i>
                                            Stock Darah
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'data_galeri') != 0) ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('admin.data.data_galeri.index') }}">
                                            <i class="fa fa-image" ></i>
                                            Data Galeri
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>    
                    {{-- @endcan --}}
                {{-- @endif --}}

                <li class="nav-item ">
                    <a class="nav-link {{ (strpos(Route::currentRouteName(), 'notify') != 0) ? 'active' : '' }}" href="{{ route('admin.notify.index') }}">
                        <i class="fa fa-info-circle" ></i>
                        <span class="nav-link-text" >Notify</span>
                    </a>
                </li>
                
                <li class="nav-item ">
                    <a class="nav-link {{ (strpos(Route::currentRouteName(), 'jekdon') != 0) ? 'active' : '' }}" href="#navbar-jekdon" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-jekdon">
                        <i class="ni ni-tv-2" ></i>
                        <span class="nav-link-text" >JekDon</span>
                    </a>

                    <div class="collapse {{ (strpos(Route::currentRouteName(), 'jekdon') != 0) ? 'show' : '' }}" id="navbar-jekdon">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item {{ (strpos(Route::currentRouteName(), 'order') != 0) ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.jekdon.order.index') }}">
                                    <i class="fa fa-shopping-cart" ></i>
                                    <span class="nav-link-text" >Order</span>
                                </a>
                            </li>     
                            <li class="nav-item {{ (strpos(Route::currentRouteName(), 'hargakm') != 0) ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.jekdon.hargakm.index') }}">
                                    <i class="ni ni-money-coins" ></i>
                                    <span class="nav-link-text" >Harga KM</span>
                                </a>
                            </li>                
                        </ul>
                    </div>
                </li>
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Documentation</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
                        <i class="ni ni-spaceship"></i> Getting started
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
                        <i class="ni ni-palette"></i> Foundation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html">
                        <i class="ni ni-ui-04"></i> Components
                    </a>
                </li>
            </ul>
        </div>
    </div>
    

    <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
            <div class="col-xl-12">
                <div class="copyright text-center text-xl-left text-muted">
                    © 2020 <a href="#">SIDONI KAB. TANGERANG</a>
                </div>
            </div>
        </div>
    </footer>
</nav>