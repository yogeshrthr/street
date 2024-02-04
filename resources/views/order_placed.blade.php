 <x-front_header />
 <style>
     body {
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
 </style>
 <section style="margin-top:50 ;" class="catlist">
     <div class="container-fluid m-2">
         <div class="row ">
            <div  class="container mt-5">
                <div class="text-center">
                    <h1 class="text-success">&#10003; Order Placed Successfully!</h1>
                    <p class="lead">Your order with ID <strong>#{{$order_id}}</strong> has been successfully placed. Thank you for shopping with us!</p>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{url('/')}}" class="btn btn-primary">Go to Home</a>
                </div>
            </div>
         </div>
     </div>
 </section>
 
 <x-front_footer />
 <script src="https://code.jquery.com/jquery-3.7.0.min.js"
     integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
 <script src="js/index.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
 </script>
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(document).ready(function(){
       
    });
</script>

 </body>

 </html>
