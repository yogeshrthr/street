<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Street Bolt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css" />
</head>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
</script>


<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h5>Sign in</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <p class="f-text1">Become a member-dont miss out on deals,offers,discounts and bonus vouchers.</p>
            <div class="modal-body">

                <form id="signup_form">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="login_email" required>
                        <span id="loginEmailResponse"></span>

                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="login_password" required>
                        <span id="loginPasswordResponse"></span>
                    </div>
                    <div class="row m-0">
                        <div class="mb-3 form-check col-md-6 col-6">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                        </div>
                        <div class="col-md-6 col-6">
                            <p class="pt">Forgot Password ?</p>
                        </div>
                        <p id="LoginResponse"></p>
                    </div>
                    <input type="submit" name="submit" class="BT btn btn-ssuccess w-100" id="loginBtn"
                        value="SIGN IN">
                    <input type="button" name="submit" class="BN btn btn-ssuccess w-100" type="button"
                        data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" value="REGISTER">
                    <p class="info">Membership info</p>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5>Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="form-1">
                    <form id="form-2">

                        <div class="row">
                            <div class="mb-3 col-md-6 col-6">
                                <input type="name" class="form-control" id="first_name" placeholder="First Name *"
                                    required oninput="remove_error(this.id)">
                                <span id="first_nameResponse"></span>
                            </div>
                            <div class="mb-3 col-md-6 col-6">
                                <input type="name" class="form-control" id="last_name" placeholder="Last Name *"
                                    required oninput="remove_error(this.id)">
                                <span id="last_nameResponse"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="signUpEmail" placeholder="Email ID *"
                                required oninput="remove_error(this.id)">
                            <span id="signUpEmailResponse"></span>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="signUpPassword"
                                placeholder="Choose New Password *" required oninput="remove_error(this.id)">
                            <span id="signUpPasswordResponse"></span>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" id="signUpConfirmPassword"
                                placeholder="Confirm Password *" required oninput="remove_error(this.id)">
                            <span id="signUpConfirmPasswordResponse"></span>
                        </div>
                        <div class="mb-3">

                            <input type="number" class="form-control" id="signUpMobile"
                                placeholder="+91 Mobile Number(For order status update) *" required oninput="remove_error(this.id)">
                            <span id="signUpMobileResponse"></span>
                        </div>
                        Gender:

                        <input type="radio" value="Male" class="gender" name="gender" checked />Male
                        <input type="radio" value="Female" class="gender" name="gender" />Female
                        <input type="radio" value="Transgender" class="gender" name="gender" />Other
                        <p id="SignupResponse"></p>
                        <input type="button" name="submit" class="BT btn btn-ssuccess w-100 my-3" id="signUpBtn"
                            value="REGISTER">
                        <p>Already a Customer? <span type="button" id="exampleModalToggle" onclick="LoginNow()"
                                class="login"> Login</span></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>












<script>
    function LoginNow() {
      $('#exampleModalToggle').modal('show');
      $('#exampleModalToggle2').modal('hide');
    }

    $('#loginBtn').click(function(e) {
        
        e.preventDefault();
        var email = $('#login_email').val();
        var password = $('#login_password').val();
        if (email == '') {
            $('#loginEmailResponse').html('<font color="red">Required Email ID</font>');
            $('#login_email').focus();
        } else if (password == '') {
            $('#loginPasswordResponse').html('<font color="red">Required Password.</font>');
            $('#loginEmailResponse').html('');
            $('#login_password').focus();

        } else {
            $.post("{{ route('user-login') }}", {
                email: email,
                password: password,
                '_token': '{{ csrf_token() }}'
            }, function(result) {
                console.log(result);
                if(result == 3) {
                  window.location.href = 'checkout';
                }
                if (result == 2 || result == 0) {
                    $('#loginEmailResponse').fadeOut();
                    $('#loginPasswordResponse').fadeOut();
                    $('#LoginResponse').html('<font color="red">Incorrect Login Credentials.</font>');
                }

                if (result == 1) {
                    $('#loginEmailResponse').fadeOut();
                    $('#loginPasswordResponse').fadeOut();
                    $('#LoginResponse').html('<font color="green">Login successfully.</font>');
                    setTimeout(window.location.reload(), 4000);
                }
            });
        }
    });


    /*$('#signUpBtn').click(function() {
        var name = $('#register_name').val();
        var email = $('#register_email').val();
        console.log(name,email)
        return false
        var atPos = email.indexOf("@");
        var dotPos = email.indexOf(".");
        var emailLength = email.length;
        var password = $('#register_password').val();
        var confirm_password = $('#register_confirm_password').val();
        var mobile = $('#register_phone').val();

        if (name == '') {
            $('#registerNameResponse').html('<small class="text-danger"><em>* Please Enter Name.</em></small>');
            $('#registerNameResponse').fadeIn().fadeOut(3000);
        } else if (email == '') {
            $('#registerEmailResponse').html('<small class="text-danger"><em>* Please Enter Email.</em></small>');
            $('#registerEmailResponse').fadeIn().fadeOut(5000);
        } else if (atPos < 1 || dotPos < atPos + 2 || dotPos + 2 > emailLength) {
            $('#registerEmailResponse').html('<small class="text-danger"><em>* You Entered Invalid Email.</em></small>');
            $('#registerEmailResponse').fadeIn().fadeOut(5000);

        } else if (mobile == '') {
            $('#registerPhoneResponse').html('<small class="text-danger"><em>* Please Enter Your Phone Number.</em></small>');
            $('#registerPhoneResponse').fadeIn().fadeOut(5000);

        } else if (mobile.length > 10 || mobile.length < 10) {
            $('#registerPhoneResponse').html('<small class="text-danger"><em>* Enter 10 Digit Mobile Number.</em></small>');
            $('#registerPhoneResponse').fadeIn().fadeOut(5000);
        } else if (password == '') {
            $('#registerPasswordResponse').html('<small class="text-danger"><em>* Please Enter Password.</em></small>');
            $('#registerPasswordResponse').fadeIn().fadeOut(5000);
        } else if (password.length < 6) {
            $('#registerPasswordResponse').html(
                '<small class="text-danger"><em>* Password Must be Atleast 6 Character.</em></small>');
            $('#registerPasswordResponse').fadeIn().fadeOut(5000);
        } else if (confirm_password == '') {
            $('#registerConfirmPasswordResponse').html('<small class="text-danger"><em>* Please Confirm Password.</em></small>');
            $('#registerConfirmPasswordResponse').fadeIn().fadeOut(5000);
        } else if (password != confirm_password) {
            $('#registerConfirmPasswordResponse').html(
                '<small class="text-danger"><em>* Password Confirmation Failed.</em></small>');
            $('#registerConfirmPasswordResponse').fadeIn().fadeOut(5000);
        } else {
            $.post("{{ route('user-signup') }}", {
                name: name,
                email: email,
                mobile: mobile,
                password: password,
                '_token': '{{ csrf_token() }}'
            }, function(result) {
                console.log(result);
                if (result == 2) {
                    $('#SignupResponse').html('<small class="text-danger"><em>* Mobile Number Already Registered.</em></small>');
                }

                if (result == 0) {
                    $('#SignupResponse').html('<small class="text-danger"><em>* Email Already Registered.</em></small>');
                }

                if (result == 1) {
                    $('#SignupResponse').html('<small class="text-success"><em>* Registration Successfull.</em></small>');
                    window.location.href = 'login';
                }
            });
        }
    });*/
    $(document).ready(function () {
        // Function to validate the email format
        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var atSymbolCount = (email.match(/@/g) || []).length;
            return atSymbolCount === 1 && emailRegex.test(email);
        }

        // Function to validate the mobile number format
        function isValidMobile(mobile) {
            var mobileRegex = /^[0-9]{10}$/;
            return mobileRegex.test(mobile);
        }

        // Function to validate the password format
        function isValidPassword(password) {
            // Customize password validation as needed (e.g., minimum length)
            return password.length >= 8;
        }

        // Function to validate the name format
        function isValidName(name) {
            // Customize name validation as needed
            var regex = /^[a-zA-Z][a-zA-Z0-9\-_ ]*$/;
            return name.length > 0 && regex.test(name);
        }

        // Event handler for form submission
        $("#signUpBtn").click(function () {
            var firstName = $("#first_name").val();
            var lastName = $("#last_name").val();
            var email = $("#signUpEmail").val();
            var password = $("#signUpPassword").val();
            var confirmPassword = $("#signUpConfirmPassword").val();
            var mobile = $("#signUpMobile").val();
            var error =false;
            // Reset previous validation messages and styling
            $(".response-message").text('');
            $(".form-control").removeClass('is-invalid');

            // Validate First Name
            if (!isValidName(firstName)) {
                $("#first_nameResponse").text("Please enter a valid first name.").addClass('text-danger');
                $("#first_name").addClass('is-invalid');
                error=true;
            }

            // Validate Last Name
            if (!isValidName(lastName)) {
                $("#last_nameResponse").text("Please enter a valid last name.").addClass('text-danger');
                $("#last_name").addClass('is-invalid');
                error=true;
            }

            // Validate Email
            if (!isValidEmail(email)) {
                $("#signUpEmailResponse").text("Please enter a valid email address.").addClass('text-danger');
                $("#signUpEmail").addClass('is-invalid');
                error=true;
            }

            // Validate Password
            if (!isValidPassword(password)) {
                $("#signUpPasswordResponse").text("Password must be at least 8 characters long.").addClass('text-danger');
                $("#signUpPassword").addClass('is-invalid');
                error=true;
            }

            // Validate Confirm Password
            if (password !== confirmPassword) {
                $("#signUpConfirmPasswordResponse").text("Passwords do not match.").addClass('text-danger');
                $("#signUpConfirmPassword").addClass('is-invalid');
                error=true;
            }

            // Validate Mobile Number
            if (!isValidMobile(mobile)) {
                $("#signUpMobileResponse").text("Please enter a valid mobile number.").addClass('text-danger');
                $("#signUpMobile").addClass('is-invalid');
                error=true;
            }
            if(error){
                return false;
            } else {
                $.post("{{ route('user-signup') }}", {
                    name: firstName+' '+lastName,
                    email: email,
                    mobile: mobile,
                    password: password,
                    '_token': '{{ csrf_token() }}'
                }, function(result) {
                    console.log(result);
                    if (result == 2) {
                        $('#SignupResponse').html('<small class="text-danger"><em>* Mobile Number Already Registered.</em></small>');
                    }

                    if (result == 0) {
                        $('#SignupResponse').html('<small class="text-danger"><em>* Email Already Registered.</em></small>');
                    }

                    if (result == 1) {
                        $('#SignupResponse').html('<small class="text-success"><em>* Registration Successfull.</em></small>');
                        //window.location.href = 'login';
                        $('#exampleModalToggle').modal('hide');
                        $('#form-2')[0].reset();
                        Swal.fire({
                            title: "Good job!",
                            text: "You clicked the button!",
                            icon: "success"
                        }).then((result) => {
                            // Check if the "OK" button was clicked
                            if (result.isConfirmed) {
                                // Refresh the page
                                location.reload();
                            }
                        });

                    }
                });
            }
                
            
            // If all validations pass, you can proceed with form submission or any other logic
            // For now, let's just display a success message
           // $("#SignupResponse").text("Registration successful!").addClass('text-success');
        });
    });  
    function remove_error(id){
        $('#'+id+'Response').text('').removeClass('text-danger');
        $('#'+id).removeClass('is-invalid');
    } 
    $('#signup_form').on('submit',function(e){
        e.preventdefault();
        $('#signUpBtn').click();
    })
    $('#form-2').on('submit',function(e){
        e.preventdefault();
        $('#loginBtn').click();
    })
</script>
