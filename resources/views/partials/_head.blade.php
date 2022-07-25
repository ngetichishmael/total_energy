<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="Devint">
   <title>@yield('title') - sokoflow</title>
   <link rel="apple-touch-icon" href="{!! asset('app-assets/images/ico/apple-icon-120.png') !!}">
   <link rel="shortcut icon" type="image/x-icon" href="{!! asset('app-assets/images/favicon.png') !!}">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

   <!-- BEGIN: Vendor CSS-->
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/css/vendors.min.css') !!}">
   <!-- END: Vendor CSS-->

   <!-- BEGIN: Theme CSS-->
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/bootstrap.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/bootstrap-extended.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/colors.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/components.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/themes/dark-layout.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/themes/bordered-layout.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/themes/semi-dark-layout.css') !!}">

   <!-- BEGIN: Page CSS-->
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/core/menu/menu-types/vertical-menu.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/plugins/forms/form-validation.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/css/pages/page-auth.css') !!}">
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   <link type="text/css" rel="stylesheet" href="{!! asset('assets/image-uploader/dist/image-uploader.min.css') !!}">
   <!-- END: Page CSS-->

   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/vendors/css/forms/select/select2.min.css') !!}">
   <link rel="stylesheet" type="text/css" href="{!! asset('app-assets/fonts/fontawesome/css/all.min.css') !!}">

   @yield('stylesheets')

   <!-- BEGIN: Custom CSS-->
   <link rel="stylesheet" type="text/css" href="{!! asset('assets/css/style.css') !!}">
   <!-- END: Custom CSS-->
   <livewire:styles />
</head>
