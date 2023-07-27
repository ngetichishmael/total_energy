@extends('layouts.app')
{{-- page header --}}
@section('title', 'Customer')
{{-- page styles --}}
@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection

{{-- content section --}}
@section('content')
    <style>
        /* custom.css */

        /* Theme color */
        :root {
            --theme-color: #fc0103;
        }

        /* Target the whole DataTable */
        #customerTable {
            border-collapse: collapse;
            width: 100%;
        }

        /* Header styling */
        #customerTable thead th {
            background-color: var(--theme-color);
            color: #fff;
            /* Text color for the header */
            text-align: left;
            padding: 10px;
        }

        /* Even and odd rows */
        #customerTable tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #customerTable tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Cell padding and alignment */
        #customerTable td {
            padding: 8px;
        }

        /* Add borders to cells */
        #customerTable td,
        #customerTable th {
            border: 1px solid #dddddd;
        }

        /* Custom class for specific column styling */
        #customerTable .action-column {
            text-align: center;
        }

        /* Custom class for buttons in the action column */
        #customerTable .dropdown-menu .dropdown-item {
            color: var(--theme-color);
        }

        #customerTable .dropdown-menu .dropdown-item:hover {
            background-color: #f2f2f2;
        }

        #customerTable_paginate {
            text-align: center;
        }

        /* Pagination button style */
        #customerTable_paginate .paginate_button {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #fc0103;
            /* Theme color */
            cursor: pointer;
            border-radius: 5px;
        }

        /* Active pagination button style */
        #customerTable_paginate .paginate_button.current {
            background-color: #fc0103 !important;
            /* Theme color */
            color: #fff;
        }

        /* Disabled pagination button style */
        #customerTable_paginate .paginate_button.disabled {
            pointer-events: none;
            /* Disable clicking on disabled buttons */
            color: #ccc;
        }

        /* Pagination button hover style */
        #customerTable_paginate .paginate_button:hover {
            background-color: #fc0103;
            /* Theme color */
            color: #fff;
        }

        .material-symbols-outlined {
            font-variation-settings:
                'FILL'0,
                'wght'50,
                'GRAD'0,
                'opsz'24
        }
    </style>
    <!-- begin breadcrumb -->
    <div class="row mb-2">
        <div class="col-md-8">
            <h2 class="page-header">Customers List</h2>
        </div>
        <div class="col-md-4">
            <center>
                <a href="{!! route('customer.create') !!}" class="btn btn-primary btn-sm"><i class="fa fa-user-plus"></i> Add a
                    Customer</a>
                <a href="{{ route('user-import') }}" class="btn btn-info btn-sm"><i class="fa fa-file-upload"></i> Import
                    Customer</a>
                {{-- <a href="{!! route('customer.export','csv') !!}" class="btn btn-warning btn-sm"><i class="fal fa-file-download"></i> Export Customer</a> --}}
            </center>
        </div>
    </div>
    <!-- end breadcrumb -->
    <div>
        <div>

            <div class="card card-default">
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="customerTable" class="display">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
                                    <th>Group</th>
                                    <th>Creator</th>
                                    <th>Phone Number</th>
                                    <th>Zone</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table body will be populated dynamically with JavaScript -->
                            </tbody>
                        </table>

                        <!-- Include jQuery and DataTables JavaScript -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                        <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
                        <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
                        <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js"></script>

                        <!-- JavaScript code to populate DataTable -->
                        <script>
                            $(document).ready(function() {
                                // DataTables initialization with AJAX
                                $('#customerTable').DataTable({
                                    ajax: {
                                        url: '/api/get/ui/customers', // Your API endpoint
                                        type: 'GET',
                                        dataType: 'json',
                                        dataSrc: 'data' // The key containing the data array in the API response
                                    },
                                    columns: [{
                                            data: null,
                                            render: function(data, type, row, meta) {
                                                // 'meta.row' returns the index of the row, starting from 0
                                                // Increment the index by 1 to get the row number
                                                return meta.row + 1;
                                            }
                                        },

                                        {
                                            data: 'customer_name'
                                        },
                                        {
                                            data: 'address'
                                        },
                                        {
                                            data: 'group'
                                        },
                                        {
                                            data: 'creator'
                                        },
                                        {
                                            data: 'phone_number'
                                        },
                                        {
                                            data: 'zone'
                                        },
                                        {
                                            data: 'date'
                                        },
                                        {
                                            data: null,
                                            render: function(data, type, row) {
                                                return `
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    style="background-color: #fc0103 !important;"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                       <span class="material-symbols-outlined">settings</span>
                                    </button>
                                    <div class="dropdown-menu g-25" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item btn btn-flat-primary btn-sm"
                                            href="/make/orders/${data.id}">Order</a>
                                        <a class="dropdown-item btn btn-flat-primary btn-sm"
                                            href="/customer/edit/${data.id}">Edit</a>
                                    </div>
                                </div>
                            `;
                                            }
                                        }
                                    ],
                                    dom: 'Bfrtip',
                                    extend: 'collection', // Display the export buttons
                                    buttons: [{
                                            extend: 'copy',
                                            text: 'Copy',
                                            className: 'btn btn-primary'
                                        },
                                        {
                                            extend: 'excel',
                                            text: 'Excel',
                                            className: 'btn btn-primary'
                                        },
                                        {
                                            extend: 'csv',
                                            text: 'CSV',
                                            className: 'btn btn-primary'
                                        },
                                        {
                                            extend: 'pdf',
                                            text: 'PDF',
                                            className: 'btn btn-primary'
                                        },
                                        {
                                            extend: 'print',
                                            text: 'Print',
                                            className: 'btn btn-primary'
                                        }
                                    ] // Add the export buttons
                                });
                                // Add date range picker to the input field
                                $("div.datesearchbox").html(
                                    '<div class="input-group align-content-end"> <div class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </div><input type="text" class="form-control pull-right" id="datesearch" placeholder="Search by date range.."> </div>'
                                );

                                document.getElementsByClassName("datesearchbox")[0].style.textAlign = "right";

                                // Apply the date filter on change of the date range
                                $('#datesearch').daterangepicker({
                                    autoUpdateInput: false,
                                    locale: {
                                        format: 'DD/MM/YYYY'
                                    }
                                });

                                $('#datesearch').on('apply.daterangepicker', function(ev, picker) {
                                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                                        'DD/MM/YYYY'));
                                    var startDate = picker.startDate.format('DD/MM/YYYY');
                                    var endDate = picker.endDate.format('DD/MM/YYYY');

                                    // Add the custom filter function for date range
                                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                                        var dateRegistered = data[2]; // The third column (Tanggal Terdaftar)
                                        dateRegistered = dateRegistered.split("/").reverse().join(
                                            "/"); // Convert to the format: YYYY/MM/DD
                                        return (startDate === '' && endDate === '') ||
                                            (startDate === '' && dateRegistered <= endDate) ||
                                            (startDate <= dateRegistered && endDate === '') ||
                                            (startDate <= dateRegistered && dateRegistered <= endDate);
                                    });

                                    dataTable.draw(); // Redraw the DataTable with the applied filter
                                });

                                // Clear the date filter
                                $('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
                                    $(this).val('');
                                    $.fn.dataTable.ext.search.pop(); // Remove the custom filter function
                                    dataTable.draw(); // Redraw the DataTable without the filter
                                });


                            });
                        </script>

                        {{-- @livewire('customers.dashboard') --}}

                        {{-- @livewire('customers.index') --}}
                    @endsection
                    {{-- page scripts --}}
                    @section('script')
                        <!-- Include jQuery and DataTables JavaScript -->

                    @endsection
