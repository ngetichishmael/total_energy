<div class="row">
    <div class="col-12">
        <div class="card card-inverse">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" href="#tabOne" role="tab">Tab One</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" href="#tabTwo" role="tab">Tab Two</button>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Tab One Content -->
                    <div class="tab-pane active" id="tabOne" role="tabpanel">
                        @include('livewire.users.users')
                    </div>

                    <!-- Tab Two Content -->
                    <div class="tab-pane" id="tabTwo" role="tabpanel">
                        @include('livewire.users.groups')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
