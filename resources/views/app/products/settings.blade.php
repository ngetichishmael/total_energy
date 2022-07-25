@extends('layouts.app')
{{-- page header --}}
@section('title','Settings')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">Items</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Items Settings | {!! $product->product_name !!}</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         @include('app.finance.partials._shop_menu')
         <div class="col-md-9">
            <div class="panel panel-default">
               <div class="panel-heading">
                  {!! $product->product_name !!} -  Settings
               </div>
               <div class="panel-body">
                  <div class="col-md-12">
                     <div class="form-group">
                        {!! Form::label('title', 'Online Payment Link', array('class'=>'control-label')) !!}
                        <input type="text" class="form-control" value="{!! Wingu::payment_link() !!}/product/{!! Wingu::business()->businessID !!}/{!! $product->product_code !!}" readonly>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
