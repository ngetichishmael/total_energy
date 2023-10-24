<div class="card card-statistics">
    <div class="card-header">
        <h4 class="card-title">Statistics</h4>
        <div class="d-flex align-items-center">
            <p class="mb-0 card-text font-small-2 mr-25">Default Shows Monthly Report</p>
        </div>
    </div>
    <div class="card">
        <div class="mt-0 card-body statistics-body">
            <div class="row">
                <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                    <a href="#salesSection" class="d-flex align-items-center">
                        <div class="avatar bg-light-warning">
                            <div class="avatar-content">
                                <span class="material-symbols-outlined">inventory</span>
                            </div>
                        </div> &nbsp;&nbsp;
                        <div class="pl-3 my-auto ml-3 media-body">
                            <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                &nbsp;{{ number_format($vansales) }}</h4>
                            <p class="mb-0 card-text font-small-3 font-medium-1" style="color: rgba(71,75,79,0.76)">Van
                                Sales</p>
                        </div>
                    </a>
                </div>

                <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                    <a href="#salesSection" class="d-flex align-items-center">
                        <div class="avatar bg-light-primary">
                            <div class="avatar-content">
                                <span class="material-symbols-outlined">shopping_cart</span>
                            </div>
                        </div> &nbsp;&nbsp;
                        <div class="pl-3 my-auto ml-3 media-body">
                            <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                {{ number_format($preorder) }}</h4>
                            <p class="mb-0 card-text font-small-3 font-medium-1" style="color: rgba(71,75,79,0.76)">
                                Pre-Orders</p>
                        </div>
                    </a>
                </div>
                <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                    <a href="#buyingCustomersSection" class="d-flex align-items-center">
                        <div class="avatar bg-light-success">
                            <div class="avatar-content">
                                <span class="material-symbols-outlined"> check_circle </span>
                            </div>
                        </div> &nbsp;&nbsp;
                        <div class="pl-3 my-auto ml-3 media-body">
                            <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                {{ number_format($customersCount) }}</h4>
                            <p class="mb-0 card-text font-small-3 font-medium-1" style="color: rgba(71,75,79,0.76)">
                                Customers</p>
                        </div>
                    </a>
                </div>
                <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                    <a href="#distributorsOrders" class="d-flex align-items-center">
                        <div class="avatar bg-light-info">
                            <div class="avatar-content">
                                <span class="material-symbols-outlined">order_approve</span>
                            </div>
                        </div> &nbsp;&nbsp;
                        <div class="pl-3 my-auto ml-3 media-body">
                            <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                {{ number_format($strike) }} </h4>
                            <p class="mb-0 card-text font-small-3 font-medium-1" style="color: rgba(71,75,79,0.76)">
                                Visits</p>
                        </div>
                    </a>
                </div>

                <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                    <a href="#orderFulfillmentSection" class="d-flex align-items-center">
                        <div class="avatar bg-light-primary">
                            <div class="avatar-content">
                                <span class="material-symbols-outlined">local_shipping</span>
                            </div>
                        </div> &nbsp;&nbsp;
                        <div class="pl-3 my-auto ml-3 media-body">
                            <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                {{ number_format($deliveryCount) }}</h4>
                            <p class="mb-0 card-text font-small-3 font-medium-1" style="color: rgba(71,75,79,0.76)">
                                Deliveries</p>
                        </div>
                    </a>
                </div>
                <div class="mb-2 col-xl-2 col-sm-4 col-12 mb-xl-0">
                    <a href="#systemUsers" class="d-flex align-items-center">
                        <div class="avatar bg-light-success">
                            <div class="avatar-content">
                                <span class="material-symbols-outlined">people</span>
                            </div>
                        </div> &nbsp;&nbsp;
                        <div class="pl-3 my-auto ml-3 media-body">
                            <h4 class="ml-2 font-weight-bolder" style="font-weight: bolder">
                                {{ number_format($activeUser) }} </h4>
                            <p class="mb-0 card-text font-small-3 font-medium-1" style="color: rgba(71,75,79,0.76)">
                                Users</p>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
