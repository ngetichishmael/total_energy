<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
@section('title', 'Login')
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
                        <img src="{{ asset('app-assets/images/logo.png') }}" class="logo" alt="TotalEnergies" style="width:250px; height:150px;"/>
                    </div>

                    <div class="card-body">
                        <!-- <h4 class="mb-1 card-title">Welcome to Total Energies! 👋</h4> -->
                        <p class="mb-2 card-text">Please sign-in to your account</p>
                        @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                        <form class="mt-2 auth-login-form" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-1">
                                <label for="login-email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="login-email" name="email"
                                    placeholder="john@example.com" aria-describedby="login-email" tabindex="1"
                                    autofocus />
                
                            </div>
                            <div class="mb-1">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="login-password">Password</label>
                                    <a href="{{ route('password.request') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control form-control-merge" id="login-password"
                                        name="password" tabindex="2"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="login-password" />
                                    <span class="cursor-pointer input-group-text"><i data-feather="eye"></i></span>
                              
                                </div>
                            </div>
                            <div class="mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div>
                      
                            <button type="submit" class="btn btn-primary w-100" tabindex="4" style="background: linear-gradient(to right, red, blue); color: white;">Sign in</button>

                        </form>
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
