@extends('layouts.app1')

{{-- page header --}}
@section('title', 'Order Details')

@section('page-style')
    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/pages/app-invoice.css') }}">
@endsection

@section('content')
    <section class="invoice-preview-wrapper">
        @include('partials._messages')
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-xl-9 col-md-8 col-12">
                <div class="card invoice-preview-card">
                    <div class="card-body invoice-padding pb-0">
                        <!-- Header starts -->
                        <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                            <div>
                                <div class="logo-wrapper">
                                    <!-- Include your logo here if needed -->
                                </div>
                                <p class="card-text mb-25">Main Office, Total Energies</p>
                                <p class="card-text mb-25">Nairobi Kenya</p>
                                <p class="card-text mb-0">+254 (123) 456 7891 </p>
                                <p class="card-text mb-0">
                                    <b> Order Status </b> :
                                    <span class="badge badge-pill badge-light-success mr-1">
                                        {{ $order->order_status ?? '' }}
                                    </span>
                                </p>
                            </div>
                            <div class="mt-md-0 mt-2">
                                <h4 class="invoice-title">
                                    Invoice
                                    <span class="invoice-number">#{!! $order->order_code !!}</span>
                                </h4>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Date Issued:</p>
                                    <p class="invoice-date">{{ $order->created_at->format('Y-m-d h:i A') }}</p>
                                </div>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Due Date:</p>
                                    <p class="invoice-date">{{ $order->created_at->format('Y-m-d h:i A') }}</p>
                                </div>
                                <div class="invoice-date-wrapper">
                                    <p class="invoice-date-title">Status:</p>
                                    <p class="invoice-date">
                                        @if ($order->payment_status === 'PAID')
                                            <span class="badge badge-pill badge-light-success mr-1">
                                                {{ $order->payment_status ?? '' }}
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-light-warning mr-1">
                                                {{ $order->payment_status ?? '' }}
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Header ends -->
                    </div>

                    <hr class="invoice-spacing" />

                    <!-- Address and Contact starts -->
                    <div class="card-body invoice-padding pt-0">
                        <div class="row invoice-spacing">
                            <div class="col-xl-8 p-0">
                                <h6 class="mb-2">Invoice To:</h6>
                                <h6 class="mb-25"> {{ $customer->customer_name ?? '' }} </h6>
                                <p class="card-text mb-25"> {!! $customer->contact_person ?? '' !!} </p>
                                <p class="card-text mb-25"> {!! $customer->address ?? '' !!}</p>
                                <p class="card-text mb-25">(+254){!! $customer->phone_number ?? '' !!}</p>
                                <p class="card-text mb-0"> {!! $customer->email ?? '' !!}</p>
                            </div>
                            <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                <h6 class="mb-2">Payment Details:</h6>
                                @if ($payment)
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="pr-1">Total Due:</td>
                                                <td>
                                                    <span class="font-weight-bold">
                                                        {!! $payment->amount ?? 'N/A' !!}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pr-1">Payment Method:</td>
                                                <td>{!! $payment->payment_method ?? 'N/A' !!}</td>
                                            </tr>
                                            <tr>
                                                <td class="pr-1">Payment Date:</td>
                                                <td>{!! $payment->payment_date ?? 'N/A' !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="pr-1">No payment info available.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Address and Contact ends -->

                    <!-- Invoice Description starts -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="py-1">Description</th>
                                    <th class="py-1">SKU Code</th>
                                    <th class="py-1">Unit Price</th>
                                    <th class="py-1">Qty</th>
                                    <th class="py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr class="border-bottom">
                                        <td class="py-1">
                                            <p class="card-text font-weight-bold mb-25">{!! $item->product_name !!}</p>
                                        </td>
                                        <td class="py-1">
                                            <p class="card-text text-nowrap">{!! $item->Information->sku_code !!}</p>
                                        </td>
                                        <td class="py-1">
                                            <span class="font-weight-bold">ksh {!! number_format($item->selling_price) !!}</span>
                                        </td>
                                        <td class="py-1">
                                            <span class="font-weight-bold">{!! $item->allocated_quantity !!}</span>
                                        </td>
                                        <td class="py-1">
                                            <span class="font-weight-bold"> ksh {!! number_format($item->selling_price * $item->allocatedquantity) !!} </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body invoice-padding pb-0">
                        <div class="row invoice-sales-total-wrapper">
                            <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                <p class="card-text mb-0">
                                    <span class="font-weight-bold">Salesperson:</span> <span class="ml-75">
                                        {{ $username }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                <div class="invoice-total-wrapper">
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Subtotal:</p>
                                        <p class="invoice-total-amount"> Ksh {!! number_format($subTotal) !!} </p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Discount:</p>
                                        <p class="invoice-total-amount">Ksh 0.0</p>
                                    </div>
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Tax:</p>
                                        <p class="invoice-total-amount">{!! $item->taxrate !!} %</p>
                                    </div>
                                    <hr class="my-50" />
                                    <div class="invoice-total-item">
                                        <p class="invoice-total-title">Total:</p>
                                        <p class="invoice-total-amount"> Ksh {!! number_format($totalAmount) !!} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Description ends -->

                    <hr class="invoice-spacing" />

                    <!-- Invoice Note starts -->
                    <div class="card-body invoice-padding pt-0">
                        <div class="row">
                            <div class="col-12">
                                <span class="font-weight-bold">Note:</span>
                                <span> Extra note such as company or payment information...</span>
                            </div>
                        </div>
                    </div>
                    <!-- Invoice Note ends -->
                </div>
            </div>
            <!-- /Invoice -->

           
        </div>
    </section>
@endsection
