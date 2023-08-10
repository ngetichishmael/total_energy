@php
    $menuItems = [
        'app.dashboard' => [
            'icon' => 'home',
            'title' => 'Dashboards',
            'route' => 'app.dashboard',
        ],
        'customer' => [
            'icon' => 'users',
            'title' => 'Customers',
            'subMenu' => [
                'customer.index' => [
                    'icon' => 'circle',
                    'title' => 'List',
                    'route' => 'customer',
                ],
                'outlets' => [
                    'icon' => 'circle',
                    'title' => 'Outlets',
                    'route' => 'outlets',
                ],
                'CustomerComment' => [
                    'icon' => 'circle',
                    'title' => 'Comments',
                    'route' => 'CustomerComment',
                ],
            ],
        ],
        'orders' => [
            'icon' => 'shopping-cart',
            'title' => 'Orders',
            'subMenu' => [
                'orders.pendingorders' => [
                    'icon' => 'circle',
                    'title' => 'Pending Orders',
                    'route' => 'orders.pendingorders',
                ],
                'orders.pendingdeliveries' => [
                    'icon' => 'circle',
                    'title' => 'Pending Deliveries',
                    'route' => 'orders.pendingdeliveries',
                ],
                'delivery.index' => [
                    'icon' => 'circle',
                    'title' => 'Delivery History',
                    'route' => 'delivery.index',
                ],
                'orders.vansalesaorders' => [
                    'icon' => 'circle',
                    'title' => 'Vansales Orders',
                    'route' => 'orders.vansalesorders',
                ],
            ],
        ],
    ];
@endphp
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header mb-1">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <img src="{!! asset('app-assets/images/small_logo.png') !!}" alt="soko flow" class="img" width="170px" height="50px">
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @foreach ($menuItems as $routeName => $menuItem)
                <li class="nav-item {!! Nav::isRoute($routeName) !!}">
                    <a class="d-flex align-items-center" href="{{ route($routeName) }}">
                        <i data-feather="{{ $menuItem['icon'] }}"></i>
                        <span class="menu-title text-truncate" data-i18n="Todo">{{ $menuItem['title'] }}</span>
                    </a>
                    @if (isset($menuItem['subMenu']))
                        <ul class="menu-content">
                            @foreach ($menuItem['subMenu'] as $subRoute => $subMenuItem)
                                <li style="padding-left: 20px">
                                    <a class="d-flex align-items-center {!! Nav::isRoute($subRoute) !!}"
                                        href="{{ route($subRoute) }}">
                                        <i data-feather="{{ $subMenuItem['icon'] }}"></i>
                                        <span class="menu-item text-truncate">{{ $subMenuItem['title'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach

        </ul>
    </div>
</div>
