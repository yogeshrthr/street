@php
    $title = 'Cart - Street Bolt';
@endphp
<x-front_header :title="$title" />
<link rel="stylesheet" href="assets/css/cart.css">

<style>
    main {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .empty-cart {
        text-align: center;
        padding: 50px;
    }

    .empty-cart h2 {
        color: #555;
    }

    .empty-cart img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }
</style>
<style>
    .quantity-container {
        display: flex;
        align-items: center;
    }

    .quantity {
        width: 68px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 0 5px;
        padding: 5px;
    }

    .quantity-button {
        background-color: #f8f8f8;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        padding: 5px 12px;
    }
</style>
<section class="section py-5">
@if(!empty(session('cart')) && count(session('cart')))
    <div class="container">
        <div class="Members d-flex justify-content-between">
            <span class="Members-1">Estimated delivery time:2-7 days</span>
            <span class="Members-2">Members get free shipping above Rs.1999</span>
            <span class="Members-1">Free & flexible 15 days return</span>
        </div>
        <div class="row">
            <div class="col-md-7">
                <h2 class="shopping mb-5">Shopping bag</h2>
                <div class="box-2">
                    @php
                        $cart = session()->get('cart');
                        $counter = count($cart);
                        $total = 0; 

                    @endphp
                    @if (session('cart'))
                        @foreach (session('cart') as $id => $details)
                            @php 
                            //dd($details);
                                $total += $details['price'] * $details['quantity'];
                            @endphp
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <a href="{{route('product-details')}}?id={{$details['id']}}">
                                        <img src="{{ $details['image'] }}" alt="..."
                                            style="width: 100%; height: 200px; object-fit:cover;">
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{route('product-details')}}?id={{$details['id']}}" class="h5 mt-1">{{ ucfirst($details['name']) }}</a>
                                       
                                        <span> <span style="color:red;font-weight:bold;font-size: 14px; margin-bottom: 0;">{{$details['stock'] < 10 ? $details['stock'].'Lefts Only' :''}} </span> &nbsp; &nbsp;<i class="fa-solid fa-trash-can remove-from-cart" data-id="{{ $id }}" style="cursor: pointer;"></i></span>
                                    </div>
                                    <span data-th="Price">₹ {{ number_format($details['price'],2) }}</span>
                                    <div class="row mt-1">
                                        <div class="col-md-12">
                                            <table class="table table-bordered w-100">
                                                <tbody>
                                                    <tr>
                                                        <td>Variations</td>
                                                        <td>Black</td>
                                                    </tr>
                                                    <tr data-id="{{ $id }}">
                                                        <td>Quantity</td>

                                                        <td data-th="Quantity">
                                                            <div class="quantity-container">
                                                                <button class="quantity-button quantity-minus" onclick="decrementQuantity(this)">-</button>
                                                                <input type="number" value="{{ $details['quantity'] }}" id="quantity" class="quantity update-cart">
                                                                <button class="quantity-button quantity-plus" onclick="incrementQuantity(this)">+</button>
                                                            </div>
                                                        </td>
                                                        {{--<td data-th="Quantity">
                                                            <input type="number" value="{{ $details['quantity'] }}"
                                                            class="quantity update-cart" style="width:68px;" />
                                                        </td>--}}
                                                    </tr>
                                                    <tr>
                                                        <td>Total</td>
                                                        <td data-th="Subtotal">₹ {{ number_format(($details['price'] * $details['quantity']),2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @php
                            $delivery_charge = 50;
                            $final = (float) $total + (float) $delivery_charge;
                        @endphp
                    @endif
                </div>
            </div>
            <div class="col-md-5 mt-5">
                <div class="box-5">
                    <div class="Check-delivery d-flex justify-content-between">
                        <h6 class="text-3">Check delivery time & services</h6>
                        <button type="button" id="Enter" class="">ENTER PIN CODE</button>
                    </div>
                </div>
                <div class="box-5 mt-4">
                    @if(!session()->has('customer'))
                        <h6 class="mt-4">Log in to use your personal offers!</h6>
                        {{--<a href="{{route('login')}}" type="button" id="login" class="btn">Log in</a>--}}
                        <a href="javascript::void(0)" onclick="LoginNow()" type="button" id="login" class="btn">Log in</a>
                    @endif
                    <div class="order-value">
                        <div class="d-flex justify-content-between">
                            <span>Order Value</span>
                            <span>₹ {{number_format($total,2)}}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Delivery</span>
                            <span>₹ {{number_format($delivery_charge,2)}}</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <span>Total</span>
                        <span>₹ {{number_format($final,2)}}</span>
                    </div>
                    {{--<a href="{{route('checkout')}}" type="button" id="checkout" class="btn">Continue to Checkout</a>--}}
                    <a @if(!session()->has('customer'))  onclick="LoginNow()" @else href="{{route('checkout')}}" @endif   type="button" id="checkout" class="btn">Continue to Checkout</a>
                    <p class="mt-2">We accept</p>
                    <div class="row mt-1">
                        <div class="text-6 col-md-4 col-4">Cash on Delivery</div>
                        <div class="col-md-8 col-8 d-flex justify-content-between">
                            <span class="d-flex justify-content-center align-items-center"><img src="assets/img/visa.png"
                                    class="rounded float-start" alt="..." style="width: 55%;"></span>
                            <span class="d-flex justify-content-center align-items-center"><img src="assets/img/rupay.png"
                                    class="rounded float-start" alt="..." style="width: 55%;"></span>
                            <span class="d-flex justify-content-center align-items-center"><img
                                    src="assets/img/Mastercard.png" class="rounded float-start" alt="..."
                                    style="width: 55%;"></span>
                            <span class="d-flex justify-content-center align-items-center"><img src="assets/img/emi.png"
                                    class="rounded float-start" alt="..." style="width: 55%;"></span>
                            <span class="d-flex justify-content-center align-items-center"><img src="assets/img/visa.png"
                                    class="rounded float-start" alt="..." style="width: 55%;"></span>
                        </div>
                    </div>
                    <p class="mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                        in a piece of classical Latin literature from 45 BC,
                        making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney
                        College in Virginia, looked up one of the more obscure Latin words</p>
                </div>
            </div>
        </div>
    </div>
@else
 <main>
        <div class="empty-cart">
            <img src="{{ asset('assets/img/bag.png') }}" alt="Empty Cart Image">
            <h2>Your shopping cart is empty</h2>
            <p>Explore our products and find something you like.</p>
            <a href="{{url('products')}}">Browse Products</a>
        </div>
    </main>
@endif
<div id="price_modal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="pincode-input-wrapper m-4">
            <input id="pincode" type="number" placeholder="Enter Pincode" maxlength="6" minlength="6" class="form-control">
            <div class="pincode-btn-wrapper">
                <button id="check_pincode" onclick="check_availablity_pincode($('#pincode').val())" data-v-9294f528="" class="btn-pincode">CHECK</button>
            </div>

        </div>
    </div>
  </div>
</div>
</section>
<x-front_footer />
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','.update-cart',function(e){
            e.preventDefault();
            var ele = $(this);
            $.ajax({
                url: '{{ route('update-cart') }}',
                method: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parent().parents("tr").attr("data-id"),
                    quantity: ele.val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });
    });
    $('#Enter').on('click',function(){
        $('#price_modal').modal('show');
    })
    $('#check_pincode').on('click',function(){
        $('#price_modal').modal('hide');
    })
    $(".remove-from-cart").click(function(e) {
        e.preventDefault();

        var ele = $(this);

        /*if (confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove-cart') }}',
                method: "post",
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
    function incrementQuantity(button) {
        var input = button.parentNode.querySelector('.quantity');
        var currentValue = parseInt(input.value, 10);

        if (!isNaN(currentValue)) {
            input.value = currentValue + 1;
            $('.update-cart').trigger('change');
        }
    }

    function decrementQuantity(button) {
        var input = button.parentNode.querySelector('.quantity');
        var currentValue = parseInt(input.value, 10);

        if (!isNaN(currentValue) && currentValue > 1) {
            input.value = currentValue - 1;
             $('.update-cart').trigger('change');
        }
    }
</script>
