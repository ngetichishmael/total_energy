<!-- BEGIN: Vendor JS-->
<script src="{!! asset('app-assets/vendors/js/vendors.min.js') !!}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{!! asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/jszip.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/pdfmake.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/vfs_fonts.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/buttons.html5.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/buttons.print.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') !!}"></script>
<script src="{!! asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') !!}"></script>

<script src="{!! asset('app-assets/vendors/js/forms/select/select2.full.min.js') !!}"></script>
<script src="{!! asset('app-assets/js/scripts/forms/form-select2.min.js') !!}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{!! asset('app-assets/js/core/app-menu.js') !!}"></script>
<script src="{!! asset('app-assets/js/core/app.js') !!}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{!! asset('app-assets/js/scripts/pages/page-auth-login.js') !!}"></script>
<!-- END: Page JS-->

<!-- Image Uploader Js -->
<script type="text/javascript" src="{!! asset('assets/image-uploader/dist/image-uploader.min.js') !!}"></script>

<script>
   $(window).on('load', function() {
      if (feather) {
         feather.replace({
            width: 14,
            height: 14
         });
      }
   })
</script>

<!-- ================== toastr ================== -->
<link href="{!! asset('assets/toastr/build/toastr.css') !!}" rel="stylesheet"/>
<script src="{!! asset('assets/toastr/build/toastr.min.js') !!}"></script>
@if(Session::has('success'))
   <script>
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
      toastr.success('{!! Session::get('success') !!}');
   </script>
@endif

@if(Session::has('error'))
   <script>
		toastr.options =
		{
			"closeButton": true,
			"progressBar" : true
		}
      toastr.error('{!! Session::get('error') !!}');
   </script>
@endif

@if(Session::has('warning'))
   <script>
		toastr.options =
		{
			"closeButton": true,
			"progressBar" : true
		}
      toastr.warning('{!! Session::get('warning') !!}');
   </script>
@endif

<script>
   $(".delete").on("click", function(){
       return confirm("Are you sure?");
   });
</script>
<livewire:scripts />
<script>
   var x = document.getElementById("location");
   function getLocation() {
      if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(showPosition);
      } else {
         x.innerHTML = "Geolocation is not supported by this browser.";
      }
   }

   function showPosition(position){
      x.innerHTML = '<div class="col-md-6"><label>Latitude</label><input class="form-control" value="'+ position.coords.latitude +'" name="latitude" required></div><div class="col-md-6"><label>Longitude</label><input class="form-control" value="'+ position.coords.longitude +'" name="longitude" required></div>';
   }
</script>
@yield('scripts')
