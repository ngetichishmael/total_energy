<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
   @section('title','Signup')
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
                           {{-- <a href="{!! url('login') !!}" class="brand-logo">
                              <img src="{!! asset('app-assets/images/logo.svg') !!}" alt="">
                           </a> --}}
                           <h4 class="card-title mb-1">Welcome to sokoflow! 👋</h4>
                           <p class="card-text mb-2">Signup </p>
                           @include('partials._messages')
                           <form class="auth-register-form mt-2" action="{!! route('signup') !!}" method="POST">
                              @csrf
                              <div class="mb-1">
                                 <label for="register-username" class="form-label">Your Name</label>
                                 {!! Form::text('full_names',null,['class'=>'form-control','required'=>'']) !!}
                              </div>
                              <div class="mb-1">
                                 <label for="register-email" class="form-label">Email</label>
                                 {!! Form::email('email',null,['class'=>'form-control','required'=>'']) !!}
                              </div>
                              <div class="mb-1">
                                 <label for="register-password" class="form-label">Password</label>
                                 <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control form-control-merge" id="register-password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="register-password" tabindex="3" required/>
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                 </div>
                              </div>
                              <div class="mb-1">
                                 <label for="register-password" class="form-label">Confirm Password</label>
                                 <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control form-control-merge" id="register-password" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="register-password" tabindex="3" required/>
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                 </div>
                             </div>
                              <div class="mb-1">
                                 <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="register-privacy-policy" tabindex="4" required/>
                                    <label class="form-check-label" for="register-privacy-policy">
                                       I agree to <a href="#">privacy policy & terms</a>
                                    </label>
                                 </div>
                              </div>
                              <button type="submit" class="btn btn-primary w-100" tabindex="5">Sign up</button>
                          </form>
                           <p class="text-center mt-2">
                              <span>Already a member?</span>
                              <a href="{!! url('login') !!}">
                                 <span>Login</span>
                              </a>
                           </p>
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
