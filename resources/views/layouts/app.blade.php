<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
@include('partials._head')
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="">
   <!-- BEGIN: Header-->
   @include('partials._head_nav')

   <!-- END: Header-->

   <!-- BEGIN: Main Menu-->
   @include('partials._menu')
   <!-- END: Main Menu-->

   <!-- BEGIN: Content-->
   <div class="app-content content ">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper container-xxl p-0">
         <div class="content-header row"></div>
         <div class="content-body">
            @include('partials._messages')
            @yield('content')
         </div>
      </div>
   </div>
   <!-- END: Content-->

   <div class="sidenav-overlay"></div>
   <div class="drag-target"></div>

   <!-- BEGIN: Footer-->
   <footer class="footer footer-static footer-light">
      <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a class="ms-25" href="#" target="_blank">Sokoflow</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span><span class="float-md-end d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span></p>
   </footer>
   <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
   <!-- END: Footer-->
   @include('partials._javascripts')
</body>
<!-- END: Body-->
</html>
