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
                            <img src="{{ asset('app-assets/images/logo.png') }}" class="logo" alt="TotalEnergies"
                                style="width:250px; height:150px;" />
                        </div>

                        <div class="card-body">
                            <h4 class="mb-1 card-title"> Forgot your Password? 🔒 </h4>
                            <p class="mb-2 card-text"> Enter Phone to Associated With your account and a new Password
                            </p>

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif

                            <form class="mt-2 auth-login-form" action="{{ route('password.phone') }}" method="POST">
                                @csrf
                                <div class="mb-1">
                                    <label for="login-phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="login-phone" name="phone"
                                        placeholder="070000000" aria-describedby="login-phone" tabindex="1" autofocus
                                        pattern="07\d{8}"
                                        title="Enter a valid Kenyan phone number starting with '07' and followed by 8 digits."
                                        required />
                                </div>

                                <div class="mb-1">
                                    <label for="login-password" class="form-label">New Password</label>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input type="password" class="form-control form-control-merge"
                                            id="login-password" name="password" tabindex="2" placeholder=""
                                            aria-describedby="login-password" required />
                                        <span class="cursor-pointer input-group-text"><i data-feather="eye"></i></span>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary w-100" tabindex="4"
                                    style="background: linear-gradient(to right, red, blue); color: white;">Send Reset
                                    Link</button>

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
