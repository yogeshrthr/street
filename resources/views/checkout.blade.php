@php
    $title = 'Checkout - Street Bolt';
    $cart = session()->get('cart');
    $counter = count($cart);
    $total = 0;
@endphp
<x-front_header :title="$title" />
<link rel="stylesheet" href="assets/css/cart.css">

<section class="section">
    <div class="container">
        <h2 class="Checkout mb-5">Checkout</h2>
        <form id="orderForm" action="{{ route('place-order') }}" method="POST">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $customer->user_id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="box-2">
                        <h5>Billing address</h5>
                        <h6>Enter your billing address</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="State">Full Name <span class="text-danger">*</span></label><br>
                                <input type="text" value="{{ $customer->user_name }}" name="name" id="name"
                                    autocomplete="off" required>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror<br>
                            </div>
                            <div class="col-md-6">
                                <label class="State">Email <span class="text-danger">*</span></label><br>
                                <input type="text" value="{{ $customer->user_email }}" name="email" id="email"
                                    autocomplete="off" required>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror<br>
                            </div>
                            <div class="col-md-6">
                                <label class="State">Phone <span class="text-danger">*</span></label><br>
                                <input type="number" value="{{ $customer->user_mobile }}" class="text-start"
                                    name="phone" id="phone" autocomplete="off" required>
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <br>
                            </div>
                            <div class="col-md-12">
                                <label class="State">Address <span class="text-danger">*</span></label><br>
                                <input type="text" name="address"  value="{{old('address')}}" autocomplete="off" required>
                                @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror <br>
                                <span class="postcode">street address</span>
                            </div>
                            <div class="col-md-6">
                                <label class="State">Town/City <span class="text-danger">*</span></label><br>
                                <input type="text"  value="{{old('city')}}" name="city" autocomplete="off" required>  
                                @error('city')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror                              
                                <br>
                                <span class="postcode">City/town</span>
                            </div>
                            <div class="col-md-6">
                                <label class="State">Pincode <span class="text-danger">*</span></label><br>
                                <input type="number"  value="{{old('check_pincode')}}" class="text-start" id="check_pincode" name="pin_code" autocomplete="off"
                                    required>
                                @error('pin_code')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror<br>
                                <span class="postcode">Enter your postcode.E.g.400070</span>
                            </div>
                            <div class="col-md-12">
                                <label class="State">State <span class="text-danger">*</span></label><br>
                                <select name="state" required>
                                    <option value="">Select state</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Chandigarh">Chandigarh</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                    <option value="Daman and Diu">Daman and Diu</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Lakshadweep">Lakshadweep</option>
                                    <option value="Puducherry">Puducherry</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Manipur">Manipur</option>
                                    <option value="Meghalaya">Meghalaya</option>
                                    <option value="Mizoram">Mizoram</option>
                                    <option value="Nagaland">Nagaland</option>
                                    <option value="Odisha">Odisha</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Sikkim">Sikkim</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Tripura">Tripura</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Uttarakhand">Uttarakhand</option>
                                    <option value="West Bengal">West Bengal</option>
                                </select>
                                @error('stateAre you sure want to remove?')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="box-2 mt-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>{{ $counter }} items</span>
                            </div>
                        </div>
                        <div class="row">
                            @foreach (session('cart') as $id => $details)
                                @php
                                    $total += $details['price'] * $details['quantity'];
                                @endphp
                                <div class="col-md-4">
                                    <div class="img-9 border">
                                        <img src="{{ $details['image'] }}" id="img-pant"
                                            style="width: 100%; height: 200px; object-fit:cover;">
                                        <span style="cursor: pointer;" class="icon-0 remove-from-cart"
                                            data-id="{{ $id }}"> <i
                                                class="fa-solid fa-trash-can"></i></span>
                                    </div>
                                </div>
                            @endforeach
                            @php
                                $delivery_charge = 50;
                                $final = (float) $total + (float) $delivery_charge;
                            @endphp
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                    <div class="box-2 mt-3">
                        <p>Payment</p>
                        <div class="d-flex justify-content-start w-100">
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_mode"
                                    id="PayOnlineRadio" value="online" checked>
                                <label class="form-check-label" for="PayOnlineRadio">
                                    Pay Online
                                </label>
                            </div> --}}
                            <div class="form-check ms-3">
                                <input class="form-check-input" type="radio" name="payment_mode"
                                    id="CashOnDeliveryRadio" value="Cash On Delivery" checked>
                                <label class="form-check-label" for="CashOnDeliveryRadio">
                                    Cash On Delivery
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-2">
                        <div class="Discounts-1">
                            <div class="d-flex justify-content-between">
                                <span>Order volue</span>
                                <span>₹ {{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Delivery</span>
                                <span>₹ {{ number_format($delivery_charge, 2) }}</span>
                            </div>
                        </div>
                        <div class="Total d-flex justify-content-between">
                            <span>Total</span>
                            <span>₹ {{ number_format($final, 2) }}</span>
                        </div>
                        <p class="by">By continuing,you agree to</p>
                        <span class="General">H&M's General terms and conditions.</span><br>
                        <span>We will process your personal data in accofdance with<br> the H&Ms <span
                                class="General">privacy Notice </span></span>
                        <button type="submit" id="Almost" class="btn">Order Now</button>
                        <div class="mt-4">
                            <span>Need help ? please contact<span class="General"> Customer Service</span>.</span>
                        </div>
                    </div>
                    <div class="box-2 mt-5">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <span><i class="fa-solid fa-box-open"></i></span>
                                <span>Delivery and return options</span>
                            </div>
                            <span><i class="fa-solid fa-chevron-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<x-front_footer />
<script type="text/javascript">
    $(".remove-from-cart").click(function(e) {
        e.preventDefault();
        var ele = $(this);
        /*if (confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove-cart') }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.attr("data-id")
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }*/
        Swal.fire({
            title: 'Are you sure want to remove?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('remove-cart') }}',
                    method: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.attr('data-id')
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Removed!',
                            text: 'Your item has been removed.',
                            icon: 'success'
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                });
            }
        });

    });
    $('#Almost').click(function(e){
        e.preventDefault();
       var pin=$('#check_pincode').val()
       if(pin==''){
        Swal.fire({
            title: "info!!",
            text: "Please Enter Delivery Address..",
            icon: "info",
            customClass: {
                confirmButton: 'bg-dark', // Assign a custom class to the "OK" button
            },
        });
        return false
       }
        $.ajax({
            url: "{{url('/check-pincode')}}",
            type: 'POST',
            data: {pincode:pin},
            headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.status==200){
                       $("#orderForm").submit();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry',
                        text: "We can't place your order. Delivery is not available in this pincode.",
                    });
                            }
                // Handle the success response
                console.log('Success:', response);
            },
            error: function(xhr, status, error) {
                // Handle the error response
                console.error('Error:', xhr.responseText);
            }
        });
    })
</script>
