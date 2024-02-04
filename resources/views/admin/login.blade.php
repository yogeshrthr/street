<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from demo.bootstrapdash.com/libertyui/template/demo/vertical-default-light/pages/samples/login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 25 Sep 2023 12:39:07 GMT -->
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Street Bolt Admin Login Panel</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../backend/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../backend/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="./backend/vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../backend/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../backend/vendors/feather/feather.css">
  <link rel="stylesheet" href="../backend/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../backend/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../backend/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo1">
                <img src="../backend/images/logo.png" alt="logo" style="width:238px; height:219px;">
              </div>
              <h4>Admin Panel </h4>
              
              <form class="pt-3" method="post" action="{{route('login-auth')}}">
			  @csrf
                <div class="form-group">
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="email" class="form-control form-control-lg border-left-0" id="email" name="email" placeholder="Email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control form-control-lg border-left-0" id="password" name="password" placeholder="Password" required>                        
                  </div>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-right">
                  
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="my-3">
                  <button  type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                </div>
               
               
              </form>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; <?php echo date('Y');?>  All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../backend/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../backend/js/off-canvas.js"></script>
  <script src="../backend/js/hoverable-collapse.js"></script>
  <script src="../backend/js/template.js"></script>
  <script src="../backend/js/settings.js"></script>
  <script src="../backend/js/todolist.js"></script>
  <!-- endinject -->
</body>


<!-- Mirrored from demo.bootstrapdash.com/libertyui/template/demo/vertical-default-light/pages/samples/login-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 25 Sep 2023 12:39:07 GMT -->
</html>
