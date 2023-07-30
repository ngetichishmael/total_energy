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