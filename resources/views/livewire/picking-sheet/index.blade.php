    <section class="invoice-preview-wrapper">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12">
                <div class="card invoice-preview-card">
                    <div class="pb-0 card-body invoice-padding">
                        <!-- Header starts -->
                        <div class="mt-0 d-flex justify-content-between flex-md-row flex-column invoice-spacing">
                            <div>
                                <div class="logo-wrapper">
                                    <h3 class="text-primary invoice-logo">Total Energy</h3>
                                </div>
                                <p class="card-text mb-25">Office 149, 450 Street B</p>
                                <p class="card-text mb-25">Nairobi, Kenya</p>
                                <p class="mb-0 card-text">+1 (123) 456 7891</p>
                            </div>
                            <div class="mt-2 mt-md-0">
                                <h4 class="invoice-title">
                                    Invoice
                                    <span class="invoice-number">{{ $code }}</span>
                                </h4>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Date Issued: {{ now()->format('D-m-y') }}</p>
                                    <p class="invoice-date-title">Issued by: {{ Auth::user()->name }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Header ends -->
                    </div>

                    <hr class="invoice-spacing" />
                    @php
                        $total = 0;
                        foreach ($data as $value) {
                            $total += $value['total_price'];
                        }
                    @endphp
                    <!-- Address and Contact starts -->
                    <div class="pt-0 card-body invoice-padding">
                        <div class="row invoice-spacing">
                            <div class="p-0 col-xl-8">
                                <h6 class="mb-2">Invoice From: Total Energies</h6>
                            </div>
                            <div class="p-0 mt-2 col-xl-4 mt-xl-0">
                                <h6 class="mb-2">Payment Details:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pr-1">Total Due:</td>
                                            <td><span class="font-weight-bold">{{ number_format($total) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Address and Contact ends -->

                    <!-- Invoice Description starts -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="py-1">Product Name</th>
                                    <th class="py-1">Total</th>
                                    <th class="py-1">Quantity</th>
                                    <th class="py-1">Picked</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($data as $value)
                                        <td class="py-1">
                                            <p class="card-text font-weight-bold mb-25">{{ $value['name'] }}</p>
                                        </td>
                                        <td class="py-1">
                                            <span
                                                class="font-weight-bold">{{ number_format($value['total_price']) }}</span>
                                        </td>
                                        <td class="py-1">
                                            <span class="font-weight-bold">{{ $value['count'] }}</span>
                                        </td>
                                        <td class="py-1">
                                            <span class="font-weight-bold">---------------</span>
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="invoice-spacing" />

                    <!-- Invoice Note starts -->
                    <div class="pt-0 card-body invoice-padding">
                        <div class="row">
                            <div class="col-12">
                                <span class="font-weight-bold">Note:</span>
                                <span>Picking Sheet!</span>
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Note ends -->
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="mt-2 col-xl-3 col-md-4 col-12 invoice-actions mt-md-0">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary btn-block mb-75" wire:click='download' target="_blank">
                            Download
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
    </section>
