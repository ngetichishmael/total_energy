<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
   @section('title','Reset Password')
   <!-- BEGIN: Head-->
   @include('partials._head')
   <!-- END: Head-->
   <!-- BEGIN: Body-->
   <body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
      <!-- BEGIN: Content-->
      <div class="app-content content ">
         <div class="content-overlay"></div>
         <div class="header-navbar-shadow"></div>
         <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
               <div class="auth-wrapper auth-v1 px-2">
                  <div class="auth-inner py-2">
                     <!-- Login v1 -->
                     <div class="card mb-0">
                        <div class="card-body">
                           <a href="#" class="brand-logo">
                              
                              <h2 class="brand-text text-primary ms-1">Pasanda</h2>
                           </a>
                           <h4 class="card-title mb-1">Reset Password</h4>
                           @if (session('status'))
                              <div class="alert alert-success">
                                 {{ session('status') }}
                              </div>
                           @endif
                           <form class="auth-login-form mt-2" action="{{ route('password.email') }}" method="POST">
                              @csrf
                              <div class="mb-1">
                                 <label for="login-email" class="form-label">Email</label>
                                 <input type="email" class="form-control" name="email" placeholder="john@example.com" required/>
                                 @if($errors->has('email'))
                                    <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                 @endif
                              </div>
                              <button type="submit" class="btn btn-primary w-100" tabindex="4">Get reset link</button>
                           </form>
                        </div>
                     </div>
                     <!-- /Login v1 -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- END: Content-->
      @include('partials._javascripts')
   </body>
   <!-- END: Body-->
</html>
