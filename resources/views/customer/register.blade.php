@php
    $title = 'Register - Street Bolt';
@endphp
<x-front_header :title="$title" />
<section class="section py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <form action="{{ route('user-signup') }}" method="POST">
                        @csrf
                        <div class="card-body p-4">
                            <h4 class="text-center mb-5">Sign Up</h4>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="register_name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" autocomplete="off" id="register_name" required="">
                                        <span id="registerNameResponse"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="register_phone" class="form-label">Phone No. <span class="text-danger">*</span></label>
                                        <input type="number" name="phone" class="form-control text-start" autocomplete="off" id="register_phone" required="">
                                        <span id="registerPhoneResponse"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="register_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" autocomplete="off" id="register_email" required="">
                                <span id="registerEmailResponse"></span>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="register_password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control" autocomplete="off" id="register_password" required="">
                                        <span id="registerPasswordResponse"></span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="register_confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control" autocomplete="off" id="register_confirm_password" required="">
                                        <span id="registerConfirmPasswordResponse"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="SignupResponse"></div>
                            <input type="button" name="submit" class="BT btn btn-ssuccess w-100 mt-3" id="signUpBtn"
                                value="SIGN UP">
                            <a href="{{route('login')}}" class="BN btn btn-ssuccess w-100">LOGIN</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<x-front_footer />
