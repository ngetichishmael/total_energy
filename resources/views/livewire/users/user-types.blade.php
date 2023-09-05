<div>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h1>
            @if ($groupView)
                <span class="material-symbols-outlined">lists</span> Group View
            @else
                <span class="material-symbols-outlined">view_list</span> All Users View
            @endif
        </h1>

        <div class="text-right">
            <label class="switch">
                <input type="checkbox" wire:click="toggleView">
                <span class="slider round"></span>
            </label>
            <span>{{ $groupView ? 'Group View' : 'All Users View' }}</span>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            @if ($groupView)
                @include('livewire.users.groups')
            @else
                @include('livewire.users.users')
            @endif
        </div>
    </div>
</div>
