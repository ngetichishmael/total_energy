@php
    $menuItems = [
        'clients.reports' => 'Customers',
        'preorders.reports' => 'Pre Orders',
        'vansales.reports' => 'Van Sales',
        'delivery.reports' => 'Deliveries',
        'visitation.reports' => 'Visitation',
        'target.reports' => 'Targets',
        'sidai.reports' => 'Total Users',
        'payments.reports' => 'Payments',
        'inventory.reports' => 'Inventory',
    ];
    $currentRoute = request()
        ->route()
        ->getName();
@endphp

<ul class="nav nav-tabs">
    @foreach ($menuItems as $route => $name)
        @php
            $isActive = $currentRoute === $route || ($currentRoute === 'users.reports' && $route === 'clients.reports');
        @endphp
        <li class="nav-item">
            <a href="{{ route($route) }}" class="nav-link {{ $isActive ? 'active' : '' }}"
                style="{{ !$isActive ? 'color: #5babed;' : '' }}">{{ $name }}</a>
        </li>
    @endforeach
</ul>
<br>
