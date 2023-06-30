


<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
@section('title', 'Reset Password')
<!-- BEGIN: Head-->
@include('partials._head')
<!-- END: Head-->
<!-- BEGIN: Body-->

<body>
    <div class="dashboard-landing">
        <div class="left-side">
            <nav>
               
            </nav>
            <img src="{{ asset('app-assets/images/loginpage.svg') }}" alt="" class="img-fluid">
            <!-- <h1 class="title">Total Energies</h1> -->
        </div>
        <div class="right-side">
            <div class="login-fields">
                <!-- Login v1 -->
                <div>
                      <div class="card-body">
                    <div style="display: flex; justify-content: center;">
                        <img src="{{ asset('app-assets/images/logo.png') }}" class="logo" alt="kenMeat" style="width:250px; height:150px;"/>
                    </div>

                    <div class="card-body">
                    <h4 class="mb-1 card-title"> Forgot your Password? 🔒 </h4>
                        <p class="mb-2 card-text"> Enter Email to associated with your account</p>
                 
                        @if (session('status'))
                              <div class="alert alert-success">
                                 {{ session('status') }}
                              </div>
                        @endif
                        @if($errors->has('email'))
                              <span class="help-block">
                                 <strong class="text-danger">{{ $errors->first('email') }}</strong>
                              </span>
                        @endif
                 
                        <form class="mt-2 auth-login-form" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-1">
                                <label for="login-email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="login-email" name="email"
                                    placeholder="john@example.com" aria-describedby="login-email" tabindex="1"
                                    autofocus />
                           
                            </div>
                      
                     
                            <button type="submit" class="btn btn-primary w-100" tabindex="4" style="background: linear-gradient(to right, red, blue); color: white;">Send Reset Link</button>

                        </form>
                           <p class="text-right mt-2" style="text-align: right;">
                              <a href="{{ route('logout') }}">
                                 <i data-feather="chevron-left"></i> Back to login
                              </a>
                           </p>
                    </div>
                </div>
                <!-- /Login v1 -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
    @include('partials._javascripts')
</body>
<!-- END: Body-->

</html>
