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
        'inventory.reports' => 'Distributors',
    ];
    $currentRoute = request()
        ->route()
        ->getName();
@endphp

<ul class="nav nav-tabs">
    @foreach ($menuItems as $route => $name)
        <li class="nav-item">
            <a href="{{ route($route) }}" class="nav-link {{ $currentRoute === $route ? 'active' : '' }}"
                style="{{ $currentRoute !== $route ? 'color: #1877F2;' : '' }}">{{ $name }}</a>
        </li>
    @endforeach
</ul>
<br>
