
<?php
$tag = [
    '<meta name="description" content="Awesome Product">',
    '<meta name="title" content="'. $product->name .'">',
    '<meta name="url" content="'.url()->full() .'">',
];
?>

<x-front_header :metaTags="$tag" />

 {{-- <x-front_header  /> --}}
    <style>
        .clickable-div {
            cursor: pointer;
            border: 1px solid #ccc;
            padding-top:3px;
            margin:5px;
            transition: border-color 0.3s ease; /* Add a transition for smooth effect */
        }

        .clickable-div:hover {
            border-color: blue;
        }

        .clickable-div:active {
            border-color: green;
        }
        .clickable-div.active {
            border-color: #198754;
            border-width: 2px;
        }
        .thumbnails-li{
            cursor:pointer;
        }
        .thumbnails-li.active {
            border: 2px solid green;
        }
    </style>
    <div class="container p-3" style="max-width: 1473px !important;">
        <?php $cate=DB::table('categories')->where('id',$product->category_id)->orderBy('id','ASC')->first();
        ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#"><?php echo $cate->title;?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-7" id="image-1">
                <!-- product gallery start -->
                <div class="product-gallery-wrap">
                    <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                        <a id="galleryImageLink" href="{{$product->image}}">
                            <img id="galleryImage" src="{{$product->image}}" alt="" />
                        </a>
                    </div>

                    <ul class="thumbnails" >
                        <li class="thumbnails-li" data-standard="{{$product->image}}">
                            {{--<a href="{{$product->image}}" data-standard="{{$product->image}}">--}}
                                <img  src="{{$product->image}}" alt="" />
                           {{-- </a>--}}
                        </li>
                         <?php $images=DB::table('galleries')->where('product_id',$product->id)->orderBy('id','ASC')->get();
                         foreach($images as $img){?>
                        <li class="thumbnails-li" data-standard="{{$img->image}}">
                            {{-- <a href="{{$img->image}}" data-standard="{{$img->image}}">--}}
                                <img src="{{$img->image}}" alt="" />
                            {{-- </a>--}}
                        </li>
                        <?php }?>
                        
                       
                       
                    </ul>
                </div>
                <!-- product gallery end -->
            </div>



            <div class="col-md-5">
                <?php $stock = DB::table('stocks')->where('product_id', $product->id)->orderBy('price', 'ASC')->get();                
                // Initialize arrays to collect unique results
                $allCapsResults = [];
                $firstLetterCapsResults = [];

                foreach ($stock as $record) {
                    $myArray = explode(',', $record->variation);

                    // Filter values where all characters are uppercase
                    $allCaps = array_filter($myArray, function ($element) {
                        return ctype_upper($element);
                    });

                    // Filter values where only the first letter is uppercase and the rest are lowercase
                    $firstLetterCaps = array_filter($myArray, function ($element) {
                        return (strlen($element) > 1) && (ucfirst(strtolower($element)) === $element);
                    });

                    // Merge unique results with existing results
                    $allCapsResults = array_unique(array_merge($allCapsResults, $allCaps));
                    $firstLetterCapsResults = array_unique(array_merge($firstLetterCapsResults, $firstLetterCaps));
                }
                $size=$allCapsResults;
                $color=$firstLetterCapsResults;
              ?>
               <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h1 class="title-size">{{$product->name}}</h1>
                    <p style="color:red;font-weight:bold;font-size: 14px; margin-bottom: 0;">{{ $stock[0]->stock>0 && $stock[0]->stock<11? $stock[0]->stock.' Lefts Only' :''}}</p>
                </div>
                <!-- price -->
                <div class="price-box-wrapper mb20">
                    <span class="leftPrice pull-right">
                        <span class="offer">
                            <span class="irupee">Rs.</span> <span id="product_price"> <?php echo $stock[0]->discount;?> </span>
                            <input id="pro_price" type="hidden" value="{{$stock[0]->discount??0}}">
                            <input id="stock_id" type="hidden" value="{{$stock[0]->id??0}}">
                        </span>
                <!-- price end-->
                <!-- color -->
                    <?php //dd($stock->toArray(),$color)?>
                <div class="container">
                    <div class="row">
                    @if (isset($color) && !empty($color))
                        @foreach ($color as  $key=>$item)
                            <div  class=" @if($key==0) active @endif  col-2 clickable-div" data-val="{{$item}}">
                                <input class="d-none" type="radio" name="color_radio" class="color_radio" @if($key==0) checked @endif  value="{{$item}}">
                                <img style="width:100%;" src="{{isset($stock[$key]->variation_img) ? asset($stock[$key]->variation_img): asset($product->image)}}" alt="Image 1">
                                <p>{{$item}}</p>
                            </div>
                        @endforeach
                    @endif
                   
                        
                        {{-- <div class="col-2 clickable-div" onclick="active_product_color(this)">
                            <img style="width:100%;" src="images/c1.png" alt="Image 1">
                            <p>fdsfad</p>
                        </div>

                        <div class="col-2 clickable-div" onclick="active_product_color(this)">
                            <img style="width:100%;" src="images/c1.png" alt="Image 1">
                            <p>fdsfad</p>
                        </div>

                        <div class="col-2 clickable-div" onclick="active_product_color(this)">
                            <img style="width:100%;" src="images/c1.png" alt="Image 1">
                            <p>fdsfad</p>
                        </div> --}}
                    </div>
                </div>
                                <br/>
                 <!-- color end-->
                    <?php //dd($size,$color);
                        $size_ar=['M','XXL','XL','S','XXS','XS','L'];
                    ?>
                    <ul class="sizelist mt-5">
                        @if(isset($size) && count($size))
                            @foreach ($size_ar as $key=>$items)
                                <li class="oval  unselectedSize {{!in_array($size_ar[$key], $size)? 'outstock':'' }}">
                                    <input @if($size[0]==$items) checked @endif class="size_box" type="radio" name="sub_prod" id="{{$key}}" @if(in_array($size_ar[$key], $size))  @else disabled="disabled" @endif value="{{$size_ar[$key]}}"
                                        style="z-index: -1;">
                                    <label for="{{$key}}" class=" inputLabel"
                                        style="border-radius: 0px; position: static;">
                                        <span>{{$size_ar[$key]}}</span></label>
                                </li>
                            @endforeach
                        @endif
                        {{-- <li class="oval unselectedSize {{!in_array('XS', $size)? 'outstock':'' }}">
                            <input type="radio" name="sub_prod" id="1" value="208902" style="z-index: -1;" @if(in_array('XS', $size))  @else disabled="disabled" @endif>
                            <label for="1" class="inputLabel" style="border-radius: 0px; position: static;">
                                <span class="sizetext">XS</span></label>
                        </li>
                        <li class="oval unselectedSize {{!in_array('S', $size)? 'outstock':'' }}">
                            <input type="radio" name="sub_prod" id="2" value="208902" style="z-index: -1;" @if(in_array('S', $size))  @else disabled="disabled" @endif>
                            <label for="2" class="inputLabel" style="border-radius: 0px; position: static;">
                                <span class="sizetext">S</span></label>
                        </li>
                        <li class="oval unselectedSize {{!in_array('M', $size)? 'outstock':'' }}">
                            <input type="radio" name="sub_prod" id="3" value="208902" style="z-index: -1;" @if(in_array('M', $size))  @else disabled="disabled" @endif>
                            <label for="3" class="inputLabel" style="border-radius: 0px; position: static;">
                                <span class="sizetext">M</span></label>
                        </li>
                        <li class="oval unselectedSize {{!in_array('L', $size)? 'outstock':'' }}">
                            <input type="radio" name="sub_prod" id="4" value="208902" style="z-index: -1;" @if(in_array('L', $size))  @else disabled="disabled" @endif>
                            <label for="4" class="inputLabel" style="border-radius: 0px; position: static;">
                                <span class="sizetext">L</span></label>
                        </li>
                        <li class="oval unselectedSize {{!in_array('XL', $size)? 'outstock':'' }}">
                            <input type="radio" name="sub_prod" id="5" value="208902" style="z-index: -1;" @if(in_array('XL', $size))  @else disabled="disabled" @endif>
                            <label for="5" class="inputLabel" style="border-radius: 0px; position: static;">
                                <span class="sizetext">XL</span></label>
                        </li>
                        <li class="oval unselectedSize {{!in_array('XXL', $size)? 'outstock':'' }}">
                            <input type="radio" name="sub_prod" id="5" value="208902" style="z-index: -1;" @if(in_array('XXL', $size))  @else disabled="disabled" @endif>
                            <label for="5" class="inputLabel" style="border-radius: 0px; position: static;">
                                <span class="sizetext">XXL</span></label>
                        </li> --}}
                    </ul>

                    {{--<div class="size-Gudei">
                        <span><i class="fa-solid fa-ruler"></i></span>
                        size Gudei
                    </div>

                    <p class="select-size mt-3">
                        <span class="f16 font-weight-bold">Size not available? &nbsp;</span>
                        <span class="selectcolor pointer text-uppercase font-weight-normal mb-5"><a
                                style="font-size: 15px; text-transform: capitalize;" href="#">Notify Me</a></span>
                    </p>--}}

                </div>

                <div class="d-flex align-items-center">
                    <div class="fltdiv lh28">Quantity &nbsp; </div>
                    <select id="quentity" name="quentity" class="qtyOption" style="border: 1px solid #ddd; border-radius: 5px;">
                        <option selected value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>
                        <option value="9">09</option>
                        <option value="10">10</option>
                    </select>
                </div>
                 <!-- Share -->
                <div class="share">
                    <div class="row">
                        <div class="my-2 d-flex">
                            <p style="color: #58595b;">Share</p>

                            <div class="sh">
                            <a href="https://wa.me/?text=Share Product%20{{url()->full()}}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" fill="currentColor"
                                    class="bi bi-whatsapp" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg>
                            </a>
                                
                            </div>

                            <div class="sh">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->full() }}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" fill="currentColor"
                                        class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                    </svg>
                                </a>                                
                            </div>

                            <div class="sh">
                                <a href="https://twitter.com/intent/tweet?text={{$product->name}}&url={{ url()->full() }}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" fill="currentColor"
                                        class="bi bi-twitter" viewBox="0 0 16 16">
                                        <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                    </svg>
                                </a>
                                
                            </div>
                            <div class="sh">
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->full() }}&title={{$product->name}}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" fill="currentColor"
                                    class="bi bi-linkedin" viewBox="0 0 16 16">
                                    <!-- Replace the LinkedIn SVG path data here -->
                                    <path
                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                </svg>
                            </a>

                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Share end-->
                <!-- Delivery Details -->
                 <p class="delivery-details-txt">Delivery Details</p>
                <div class="pincode-input-wrapper mb-4">
                    <input id="pincode" type="number" placeholder="Enter Pincode" maxlength="6" minlength="6" class="form-control">
                    <div class="pincode-btn-wrapper">
                        <button id="check_pincode"  onclick="check_availablity_pincode($('#pincode').val())" data-v-9294f528="" class="btn-pincode">CHECK</button>
                    </div>
                </div>
                <!-- Delivery Details end -->
                <!-- button -->
                @if($stock[0]->stock>0)
                <div id="btn_cont" class="col btnRow">
                    <button onclick="AddToCart($('#pro_price').val(),'<?php echo $product->id;?>',$('#stock_id').val(),$('#quentity').val())" type="button" class="btn btn-danger btnWidth btn-lg btn-block pointer" 
                        style="background-color: black; border-color: black;"><span><i class="fa-solid fa-bag-shopping"></i></span> Add </button>
                </div>
                @else
                <div id="btn_cont" class="col btnRow">
                    <button type="button" class="btn btn-secondary btnWidth btn-lg btn-block" disabled>
                        Out of Stock
                    </button>
                </div>
                @endif
                <!-- button end-->
                <!-- stores -->
                <div class="stores">
                    <span><i class="fa-solid fa-briefcase"></i></span>    
                     Not available in stores
                </div>

                  <div class="stores my-3">
                    <span><i class="fa-solid fa-circle-exclamation"></i></span>    
                     Standard delivery in 2-7 days
                </div>
                 <!-- stores end-->
               
                 <h5 class="Delivery">Delivery and payment</h5>
                <div class="description">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    Product Details
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <strong>Material & Care:</strong><br />Premium Heavy Gauge Fabric
                                    80% Cotton 20% Polyester
                                    Machine Wash
                                    This garment has undergone a special process that results in variations of shading
                                    and colour. It is recommended this garment be washed separately until no further
                                    colour is released.<br><strong>Country of Origin:</strong> India (and proud)<br>
                                    <strong>Manufactured & Sold By:</strong> The Souled Store Pvt. Ltd.
                                    224, Tantia Jogani Industrial Premises
                                    J.R. Boricha Marg
                                    Lower Parel (E)
                                    Mumbai - 11
                                    connect@thesouledstore.com
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseTwo">
                                    Product description
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    {{$product->description}}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                    aria-controls="panelsStayOpen-collapseThree">
                                    Artist's Details
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    The Souled Store was born out of a simple idea - love what you do and follow your
                                    soul! Thus, our goal is to give everyone something they'll love, something they can
                                    use to express themselves, and, simply put, something to put a smile on their face.
                                    So, whether it's superheroes like Superman, TV shows like F.R.I.E.N.D.S, pop
                                    culture, music, sports, or quirky, funny stuff you're looking for, we have something
                                    for everyone.

                                    TSS Originals or The Souled Store Originals is our exclusive range of funny, funky,
                                    trendy and stylish designs. Designed by our kick-ass team of in-house designers, TSS
                                    Originals are some cool and quirky designs that help you speak your vibe.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid p-3">
            <div class="h3">
                Related Product
            </div>
            <hr class="hr" />

            <section class="product-slider">
                <!--btns=========================-->
               
                <div class="slider-container">
                    <!-- Swiper -->
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            <!--1================================-->
                            
                           <?php     
                        $relatedproducts = DB::table('products')->where('category_id',$product->category_id)->get();
                        foreach($relatedproducts as $rp){
                            if($rp->id!=$product->id){
                        ?>
                            
                            <div class="swiper-slide">
                                <!--box----------------------->
                                <div class="product-box">
                                    <!--==offer==-->
                                    <span class="product-box-offer">-20%</span>
                                    <!--img-container****************-->
                                    <div class="product-img-container">

                                        <!--img=============-->
                                        <div class="product-img">
                                            <a href="{{route('product-details')}}?id={{$rp->id}}">
                                                <img class="product-img-front" src="{{$rp->image}}" alt="" />
                                                <img class="product-img-back" src="{{$rp->image}}" alt="" />
                                               <i class="wishlist fa-regular fa-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <!--text***************************-->
                                    <div class="product-box-text">
                                        
                                        <!--tile--->
                                        <a href="{{route('product-details')}}?id={{$rp->id}}"
                                            class="product-title">
                                          {{$rp->name}}
                                        </a>
                                        <!--Price--->
                                        <div class="price-buy">
                                             <?php $stocks=DB::table('stocks')->where('product_id',$rp->id)->orderBy('price','ASC')->first();
              ?>
                                            <span class="p-price">Rs.{{$stocks->price}}.00</span>
                                            
                                        </div>
                                        <!--category-->
                                        <div class="product-category">
                                            <span><?php echo $cate->title;?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php }else{
                                echo 'No product found.';
                            }}?>
                            
                            <!--2================================-->
                            
                            <!--3================================-->
                            
                            <!--6================================-->
                        
                            <!--4================================-->
                            
                            <!--5================================-->
                            

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </section>
        </div>
        </div>

   

     <x-front_footer />  

        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="dist/easyzoom.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/10.2.0/swiper-bundle.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.thumbnails-li').on('click', function (e) {

                    // Toggle active class for the clicked li element
                    // $this.toggleClass('active');
        
                    // Remove active class from other li elements
                    $('.thumbnail-li').removeClass('active');
                    
                    // $('.thumbnail-li').removeClass('active');
                    var imageUrl = $(this).attr('data-standard');
                    $('#galleryImage').attr('src', imageUrl);
                    $('#galleryImageLink').attr('href', imageUrl);
                    $(this).addClass('active');
                });
            });
        </script>
        <script>
        
        
           // Flasher.success('test');
            $('.size_box').change(function() {
                //alert($('input[name="color_radio"]:checked').val())             
                // The checkbox is checked, you can do something here                
               get_product_price()
                
            });

            $('.clickable-div').on('click', function(e) {
                if (!$(this).hasClass('active')) {
                    // Remove 'active' class from all clickable-div elements
                    $('.clickable-div').removeClass('active');
                    // Add 'active' class to the clicked element
                    $(this).addClass('active');
                    $(this).find('input[type="radio"]').prop('checked', true);
                    get_product_price();
                }
            });

            function get_product_price() {
                var color =$('input[name="color_radio"]:checked').val()              
                var size = $('input[name="sub_prod"]:checked').val();                
                if(size==''){
                    Swal.fire({
                        title: "Oops!",
                        text: "select size first",
                        icon: "info"
                    });
                    return false
                }
                if(color==''){
                    Swal.fire({
                        title: "Oops!",
                        text: "select color first",
                        icon: "info"
                    });
                    return false

                }
                console.log(color,size)
                var product_id="{{$product->id}}"
                //return false;
                $.ajax({
                    url: '/get-variation-price',
                    type: 'POST',
                    data: {size:size,color:color,product_id:product_id},
                    headers: {
                         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response)
                        if(response.status=200){
                           var order_btn = '<button onclick="AddToCart($(\'#pro_price\').val(),' + product_id + ',$(\'#stock_id\').val(),$(\'#quentity\').val())" type="button" class="btn btn-danger btnWidth btn-lg btn-block pointer" style="background-color: black; border-color: black;">\
                                <span><i class="fa-solid fa-bag-shopping"></i></span> Add\
                            </button>';
                            var out_of_stock = '<button type="button" class="btn btn-secondary btnWidth btn-lg btn-block" disabled>\
                                        Out of Stock\
                                    </button>';
                            if(response.data.in_stock>0){
                                $('#btn_cont').html(order_btn)
                            }else{
                                $('#btn_cont').html(out_of_stock)
                            }
                            
                            $('#product_price').html(response.data.price)
                            $('#stock_id').val(response.data.stock_id)
                            $('#pro_price').val(response.data.price)
                        }else{
                            window.location.reload();
                        }
                        // Handle the success response
                        console.log('Success:', response);
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error('Error:', xhr.responseText);
                    }
                });
            }
            


            // Instantiate EasyZoom instances
            var $easyzoom = $('.easyzoom').easyZoom();

            // Setup thumbnails example
            var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

            $('.thumbnails').on('click', 'a', function (e) {
                var $this = $(this);

                e.preventDefault();

                // Use EasyZoom's `swap` method
                api1.swap($this.data('standard'), $this.attr('href'));
            });

            // Setup toggles example
            var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

            $('.toggle').on('click', function () {
                var $this = $(this);

                if ($this.data("active") === true) {
                    $this.text("Switch on").data("active", false);
                    api2.teardown();
                } else {
                    $this.text("Switch off").data("active", true);
                    api2._init();
                }
            });
        </script>
        <script>
            /*Initialize Swiper*/
            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 10,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
             
                breakpoints: {
                    360: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    540: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 40,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                },
            });

        </script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="index.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>
        <script type="text/javascript" src="main.js"></script>
        <script>
            function AddToCart(price,product_id,stock_id,qty){
                //console.log(price,product_id);
                //return false;
               $.post("{{route('AddtoCart')}}",{quentity:qty,stock_id:stock_id,product_id:product_id,price:price,'_token':'{{csrf_token()}}'},function(result){
      
                 window.location.reload();
    });
            }
            
            
            
        </script>
</body>

</html>