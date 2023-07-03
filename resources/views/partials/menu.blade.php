<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
<div class="navbar-header mb-1">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="" href="#">
                   
                    <center>
                  <img src="{!! asset('app-assets/images/logoo.png') !!}" alt="Soko Flow" class="img" style="height: 60px; width: 220px;">
               </center>
                </a>
            </li>
        <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li> 
        </ul>
    </div>  



<div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {!! Nav::isRoute('app.dashboard') !!}">
                <a class="d-flex align-items-center" href="{!! route('app.dashboard') !!}">
                    <i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Todo">
                        Dashboards</span>
                </a>
            </li>
            <li class="nav-item {!! Nav::isResource('maps') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather="globe"></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Maps</span></a>
                <ul class="menu-content">
                    <li class="nav-item {!! Nav::isResource('maps') !!}">
                        <a class="d-flex align-items-center" href="{!! route('maps') !!}">
                            <i data-feather='users'></i>
                            <span class="menu-title text-truncate" data-i18n="Todo">
                                Customers</span>
                        </a>
                    </li>
                    <li class="nav-item {!! Nav::isResource('current-information') !!}">
                        <a class="d-flex align-items-center" href="{!! route('current-information') !!}">
                            <i data-feather='globe'></i>
                            <span class="menu-title text-truncate" data-i18n="Todo">
                                Sales Agents</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('product') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather="list"></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Products</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{!! route('product.index') !!}"><i
                                data-feather="circle"></i><span class="menu-item text-truncate">Products</span></a></li>
                    <li><a class="d-flex align-items-center" href="{!! route('product.category') !!}"><i
                                data-feather="circle"></i><span class="menu-item text-truncate">Categories</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{!! route('product.brand') !!}"><i
                                data-feather="circle"></i><span class="menu-item text-truncate">Brands</span></a></li>
                    {{-- <li><a class="d-flex align-items-center" href="{!! route('product.brand') !!}"><i
                                data-feather="circle"></i><span class="menu-item text-truncate">Outlets</span></a></li> --}}
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('notification') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather="bell"></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Notification</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="{{ route('CustomerNotification') }}"><i
                                data-feather="users"></i><span class="menu-item text-truncate">Customers</span></a></li>
                    <li><a class="d-flex align-items-center" href="{{ route('UserNotification') }}"><i
                                data-feather="user-check"></i><span class="menu-item text-truncate">Users</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="{{ route('AllNotification') }}"><i
                                data-feather="user-check"></i><span class="menu-item text-truncate">All
                                Notifications</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {!! Nav::isResource('regions') !!}">
                <a class="d-flex align-items-center" href="#"><i data-feather="map-pin"></i><span
                        class="menu-title text-truncate" data-i18n="Invoice">Regions</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center nav-item {!! Nav::isResource('regions') !!}"
                            href="{{ route('regions') }}"><i data-feather="map-pin"></i><span
                                class="menu-item text-truncate">Zone</span></a></li>
                    <li><a class="d-flex align-items-center {!! Nav::isResource('subregions') !!}"
                            href="{{ route('subregions') }}"><i data-feather="map-pin"></i><span
                                class="menu-item text-truncate">Region</span></a>
                    </li>
                    <li><a class="d-flex align-items-center{!! Nav::isResource('areas') !!}" href="{{ route('areas') }}"><i
                                data-feather="map-pin"></i><span class="menu-item text-truncate">Routes</span></a>
                    </li>

            </li>
        </ul>
        </li>
        <li class="nav-item {!! Nav::isResource('inventory') !!}">
            <a class="d-flex align-items-center" href="#"><i data-feather='package'></i><span
                    class="menu-title text-truncate" data-i18n="Invoice"> Inventory</span></a>
            <ul class="menu-content">
                <li><a class="d-flex align-items-center" href="{!! route('inventory.allocated') !!}"><i
                            data-feather="circle"></i><span class="menu-item text-truncate">Allocated
                            Stock</span></a></li>
            </ul>
        </li>
        <li class="nav-item {!! Nav::isRoute('customer') !!}">
            <a class="d-flex align-items-center" href="#">
                <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Todo">
                    Customers Managements</span>
            </a>
            <ul class="menu-content">
                <li><a class="d-flex align-items-center {!! Nav::isRoute('customer.*') !!}" href="{{ route('customer') }}"><i
                            data-feather="users"></i><span class="menu-item text-truncate">Customers</span></a>
                </li>
                <li><a class="d-flex align-items-center {!! Nav::isRoute('customer.*') !!}" href="{{ route('outlets') }}"><i
                            data-feather="circle"></i><span class="menu-item text-truncate">Customer
                            OutLets</span></a>
                </li>
                <li><a class="d-flex align-items-center {!! Nav::isRoute('customer.*') !!}"
                        href="{{ route('CustomerComment') }}"><i data-feather="circle"></i><span
                            class="menu-item text-truncate">Customer
                            Comments</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-item {!! Nav::isResource('visits') !!}">
            <a class="d-flex align-items-center" href="#"><i data-feather='truck'></i><span
                    class="menu-title text-truncate" data-i18n="Invoice">Visits</span></a>
            <ul class="menu-content">
                <li><a class="nav-item {!! Nav::isResource('UsersVisits') !!} d-flex align-items-center" href="{!! route('UsersVisits') !!}"><i
                            data-feather="user"></i><span class="menu-item text-truncate">Users</span></a>
                </li>
                <li><a class="d-flex align-items-center" href="{!! route('CustomerVisits') !!}"><i
                            data-feather="users"></i><span class="menu-item text-truncate">Customers</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-item {!! Nav::isResource('supplier') !!}">
            <a class="d-flex align-items-center" href="#"><i data-feather='refresh-ccw'></i><span
                    class="menu-title text-truncate" data-i18n="Invoice">Suppliers</span></a>
            <ul class="menu-content">
                <li><a class="d-flex align-items-center" href="{!! route('supplier') !!}"><i
                            data-feather="circle"></i><span class="menu-item text-truncate">Suppliers</span></a>
                </li>
                <li><a class="d-flex align-items-center" href="{!! route('supplier.category.index') !!}"><i
                            data-feather="circle"></i><span class="menu-item text-truncate">Categories</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-item {!! Nav::isResource('target') !!}">
            <a class="d-flex align-items-center" href="#"><i data-feather="target"></i><span
                    class="menu-title text-truncate" data-i18n="Invoice">Target</span></a>
            <ul class="menu-content">
                <li><a class="d-flex align-items-center" href=" {{ route('sales.target') }}"><i
                            data-feather="credit-card"></i><span class="menu-item text-truncate">Sales</span></a>
                </li>
                <li><a class="d-flex align-items-center" href="{{ route('visit.target') }}"><i
                            data-feather="truck"></i><span class="menu-item text-truncate">Visits</span></a>
                </li>
                <li><a class="d-flex align-items-center" href="{{ route('leads.target') }}"><i
                            data-feather="compass"></i><span class="menu-item text-truncate">Leads</span></a>
                </li>
                <li><a class="d-flex align-items-center" href="{{ route('order.target') }}"><i
                            data-feather="shopping-cart"></i><span class="menu-item text-truncate">Orders</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-item {!! Nav::isResource('orders') !!}">
            <a class="d-flex align-items-center" href="{!! route('orders.index') !!}">
                <i data-feather='shopping-cart'></i><span class="menu-title text-truncate" data-i18n="Todo">
                    Orders</span>
            </a>
        </li>
        <li class="nav-item {!! Nav::isResource('deliver') !!}">
            <a class="d-flex align-items-center" href="{!! route('delivery.index') !!}">
                <i data-feather='truck'></i><span class="menu-title text-truncate" data-i18n="Todo">
                    Deliveries</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='calendar'></i><span class="menu-title text-truncate" data-i18n="Todo"> Scheduled
                    visits</span>
            </a>
        </li> --}}
        <li class="nav-item {!! Nav::isRoute('*Payment') !!}">
            <a class="d-flex align-items-center" href="#">
                <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Todo">
                    Payment Management</span>
            </a>
            <ul class="menu-content">
                <li><a class="d-flex align-items-center {!! Nav::isRoute('PaidPayment') !!}"
                        href="{{ route('PaidPayment') }}"><i data-feather="users"></i><span
                            class="menu-item text-truncate">Paid</span></a>
                </li>
                <li><a class="d-flex align-items-center {!! Nav::isRoute('customer*') !!}"
                        href="{{ route('PendingPayment') }}"><i data-feather="circle"></i><span
                            class="menu-item text-truncate">Pending</span></a>
                </li>
            </ul>
        </li>
        <li class="nav-item {!! Nav::isResource('survey') !!}">
            <a class="d-flex align-items-center" href="#">
                <i data-feather='clipboard'></i><span class="menu-title text-truncate">Survey</span>
            </a>
            <ul class="menu-content">
                <li>
                    <a class="d-flex align-items-center" href="{!! route('survey.index') !!}">
                        <i data-feather="circle">
                        </i>
                        <span class="menu-item text-truncate">Survey</span>
                    </a>
                </li>
                <li>
                    <a class="d-flex align-items-center {!! Nav::isResource('survey') !!}" href="{!! route('SurveryResponses') !!}">
                        <i data-feather="circle">
                        </i>
                        <span class="menu-item text-truncate">Responses</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {!! Nav::isResource('routes') !!}">
            <a class="d-flex align-items-center" href="{!! route('routes.index') !!}">
                <i data-feather='map'></i><span class="menu-title text-truncate" data-i18n="Todo"> Route
                    Scheduling</span>
            </a>
        </li>
        <li class="nav-item {!! Nav::isResource('warehousing') !!}">
            <a class="d-flex align-items-center" href="#"><i data-feather='archive'></i><span
                    class="menu-title text-truncate" data-i18n="Invoice"> Warehousing</span></a>
            <ul class="menu-content">
                <li><a class="d-flex align-items-center" href="{!! route('warehousing.index') !!}"><i
                            data-feather="circle"></i><span class="menu-item text-truncate">All
                            Warehouses</span></a></li>
                <li><a class="d-flex align-items-center" href="{!! route('warehousing.create') !!}"><i
                            data-feather="circle"></i><span class="menu-item text-truncate">Add
                            Warehouse</span></a></li>
            </ul>
        </li>
        <li class="nav-item {!! Nav::isResource('users') !!}">
            <a class="d-flex align-items-center" href="{!! route('users.index') !!}">
                <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Todo"> Users</span>
            </a>
        </li>
        <li class="nav-item {!! Nav::isResource('settings') !!}">
            <a class="d-flex align-items-center" href="#"><i data-feather='settings'></i><span
                    class="menu-title text-truncate" data-i18n="Invoice"> Settings</span></a>
            <ul class="menu-content">
                <li><a class="d-flex align-items-center" href="{!! route('settings.account') !!}"><i
                            data-feather="circle"></i><span class="menu-item text-truncate">Account</span></a>
                </li>
            </ul>
        </li>
        </ul>
    </div>
</div>
