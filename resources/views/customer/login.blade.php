@php
    $title = 'Login - Street Bolt';
@endphp
<x-front_header :title="$title" />
<section class="section py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <form action="{{ route('user-login') }}" method="POST">
                        @csrf
                        <div class="card-body p-4">
                            <h4 class="text-center mb-5">Login</h4>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" autocomplete="off" id="login_email" required="">
                                <span id="loginEmailResponse"></span>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" autocomplete="off" id="login_password" required="">
                                <span id="loginPasswordResponse"></span>
                            </div>
                            <small><em class="text-danger mb-3" id="LoginResponse"></em></small>
                            <input type="button" name="submit" class="BT btn btn-ssuccess w-100 mt-3" id="loginBtn"
                                value="SIGN IN">
                            <a href="{{route('register')}}" class="BN btn btn-ssuccess w-100">REGISTER</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<x-front_footer />
