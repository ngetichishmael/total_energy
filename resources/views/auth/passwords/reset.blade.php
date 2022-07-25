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
                           <h4 class="card-title mb-1">Reset your password</h4>
                           <form class="auth-login-form mt-2" action="{{ route('password.request') }}" method="POST">
                              @csrf
                              <input type="hidden" name="token" value="{{ $token }}">
                              <div class="mb-1">
                                 <label for="login-email" class="form-label">Email</label>
                                 <input type="text" class="form-control" id="login-email" name="email" value="{!! $email !!}" aria-describedby="login-email" tabindex="1" autofocus />
                                 @if($errors->has('email'))
                                    <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                 @endif
                              </div>
                              <div class="mb-1">
                                 <div class="d-flex justify-content-between">
                                    <label class="form-label" for="login-password">Password</label>
                                 </div>
                                 <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    @if ($errors->has('password'))
                                       <span class="help-block">
                                          <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                       </span>
                                    @endif
                                 </div>
                              </div>
                              <div class="mb-1">
                                 <div class="d-flex justify-content-between">
                                    <label class="form-label" for="login-password">Confirm Password</label>
                                 </div>
                                 <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control form-control-merge" id="login-password" name="password_confirmation" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    @if ($errors->has('password_confirmation'))
                                       <span class="help-block">
                                          <strong class="text-danger">{{ $errors->first('password_confirmation') }}</strong>
                                       </span>
                                    @endif
                                 </div>
                              </div>
                              <button type="submit" class="btn btn-primary w-100" tabindex="4">Reset Password</button>
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
