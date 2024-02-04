 <x-front_header />
 <section class="catlist">
     <div class="container-fluid m-2">
         <div class="row ">
             <div class="col-md-3 col-12 border p-3 mt-2">
                 <div class="headig-top h6 pb-2">CATEGORIES</div>
                 <div class="category-list mt-3"><?php //dd($categories->toArray(),$_GET['cat'],);?>
                     @foreach ($categories as $cat)
                         <div class="form-check">
                             <input @if(isset($_GET['cat']) && $_GET['cat']==$cat->id ) checked @endif class="form-check-input cate" type="checkbox" value="{{ $cat->id }}"
                                 id="{{ $cat->title }}" onchange="SearchByCategory()">
                             <label class="form-check-label" for="{{ $cat->title }}">{{ $cat->title }} </label>
                         </div>
                     @endforeach
                 </div>
                 <hr />
                 <div class="headig-top h6 pb-2">SIZE</div>
                 <div class="size mt-2">
                     <button class="product_size btn btn-outline-secondary my-2">XXS</button>
                     <button class="product_size btn btn-outline-secondary my-2">XS</button>
                     <button class="product_size btn btn-outline-secondary my-2">S</button>
                     <button class="product_size btn btn-outline-secondary my-2">M</button>
                     <button class="product_size btn btn-outline-secondary my-2">L</button>
                     <button class="product_size btn btn-outline-secondary my-2">XL</button>
                     <button class="product_size btn btn-outline-secondary my-2">XXL</button>
                     <button class="product_size btn btn-outline-secondary my-2">XXXL</button>
                 </div>
                 <hr />
                 <div class="headig-top h6 pb-2">PRICES</div>
                 

                 <div id="filter-p_36" class="a-section sf-refinements-panel sf-range-content">        
                    <div class="a-section sf-filter-section s-no-js-hide">
                        <div id="range-slider"></div>
                        <p>
                            Min Price: <span id="min-price">₹1</span>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Max Price: <span id="max-price">10</span>
                        </p>
                        <input type="hidden" name="low-price" id="low-price">
                        <input type="hidden" name="high-price" id="high-price">
                        
                        <button class="btn btn-outline-secondary mt-2" onclick="resetFilters()">Reset Filters</button>
                    </div>
                </div>
             </div>
             <div class="col-md-9 col-12">
                 <!-- bredcrumb part -->
                 <div class="row">
                     <div class="col-md-6">
                         @if ($single_category)
                             <div class="p-3">
                                 <nav aria-label="breadcrumb">
                                     <ol class="breadcrumb">
                                         <li class="breadcrumb-item h6">Home</li>
                                         <li class="breadcrumb-item h6 active home_cat" >{{ $single_category->title }}</li>
                                     </ol>
                                 </nav>
                                 <div class="h5 cat_name">
                                     {{ $single_category->title }} - {{ count($product_list) }} Item
                                 </div>
                             </div>
                         @endif
                     </div>
                     <div class="col-md-6  d-flex align-items-center">
                         <div class="p-3 w-100">

                        
                             <div class=" form-group dropdown float-end">
                                <label style="display: inline-block; margin-right: 10px;">Sort By</label>
                                <select id="sortingDropdown" class="form-control" style="display: inline-block; width: auto;">
                                    <option value="">Select Options</option>
                                    <option value="0">A to Z</option>
                                    <option value="1">Price-High to Low</option>
                                    <option value="2">Price-Low to High</option>
                                    <option value="3">Newest</option>
                                    <option value="4">Popularity</option>
                                </select>
                                 {{-- <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                     id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                     Select Sorting Options
                                 </button>
                                 <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                     <li><a class="dropdown-item" data-filter="0" href="#">A to Z</a></li>
                                     <li><a class="dropdown-item" data-filter="1" href="#">Price-High to Low</a></li>
                                     <li><a class="dropdown-item" data-filter="2" href="#">Price-Low to High</a></li>
                                     <li><a class="dropdown-item" data-filter="3" href="#">Newest</a></li>
                                     <li><a class="dropdown-item" data-filter="4" href="#">Popularity</a></li>
                                 </ul> --}}
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- Loop Product  -->
                 <section class="product-catalogue">
                     <div class="container">
                         <div class="row" id="SearchList"><?php $max_p=0;?>
                             @foreach ($product_list as $pro)
                                 @php
                                     $stock = DB::table('stocks')
                                         ->where('product_id', $pro->id)
                                         ->orderBy('price', 'ASC')
                                         ->first();
                                        if($stock->discount>$max_p)
                                        $max_p=$stock->discount;
                                 @endphp
                                 <div class="col-md-4 col-sm-6">
                                     <div class="product-grid">
                                         <div class="product-image">
                                             <a href="{{ route('product-details') }}?id={{ $pro->id }}"
                                                 class="image">
                                                 <img class="pic-1" src="{{ $pro->image }}">
                                                 @if ($pro->galleries())
                                                     <img class="pic-2" src="{{ $pro->galleries()->first()->image }}">
                                                 @endif
                                             </a>
                                             <span class="product-sale-label">
                                                 {{ strtoupper($pro->category->title) }}
                                             </span>
                                             @if ($stock->price != $stock->discount)
                                                 <span class="product-discount-label">
                                                     -{{ number_format(((float) $stock->price - (float) $stock->discount) / (float) $stock->price, 2) }}%
                                                 </span>
                                             @endif
                                         </div>
                                         <div class="product-content">
                                             <h3 class="title">
                                                 <a href="{{ route('product-details') }}?id={{ $pro->id }}">
                                                     {{ $pro->name }}
                                                 </a>
                                             </h3>
                                             @if ($stock->price == $stock->discount)
                                                 <div class="price"> ₹{{ number_format($stock->price, 2) }}</div>
                                             @else
                                                 <div class="price">
                                                     <span>₹{{ number_format($stock->price, 2) }}</span>
                                                     ₹{{ number_format($stock->discount, 2) }}
                                                 </div>
                                             @endif
                                             <div class="product-button-group">
                                                 <a class="add-to-cart"
                                                     href="{{ route('product-details') }}?id={{ $pro->id }}">
                                                     <i class="fa fa-shopping-bag"></i> CHECK DETAILS
                                                 </a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     </div>
                 </section>
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
        var sort='desc';
       // var size_ar=[]
        $(document).on('click', '.product_size', function(){          
            if (!$(this).hasClass('active')) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
            SearchByCategory();
        });
    
        // sort filter
        $('#sortingDropdown').on('change', function () {
            SearchByCategory();
        });
    });
</script>
 <script>
     function SearchByCategory(sort_by='') {
        
         var arr = [];
         var size_ar=[];
         var sorted_by='';
         var price='';
         //category filter
         $('input.cate:checkbox:checked').each(function() {
             arr.push($(this).val());
         });
         //size filter
        $('.product_size').each(function() {
            if ($(this).hasClass('active')) {
                  size_ar.push($(this).text());
            }
        });
        // sort filter
        sorted_by= $('#sortingDropdown').val();
        //price filter

        price=$('#low-price').val()+'||'+$('#high-price').val();
        if(price=='||'){
            price='';
        }
        $.get("{{ route('products-by-category') }}", {
            category: arr,
            size: size_ar,
            sort:sorted_by,
            price:price,
            '_token': '{{ csrf_token() }}'
        }, function(result) {
            $('#SearchList').html(result.html);
            var cat_name = '';
            $.each(result.cat, function(index, cat) {
                cat_name += (index > 0 ? ' / ' : '') + cat.title.charAt(0).toUpperCase() + cat.title.slice(1);
            });
            $('.home_cat').html(cat_name)
            $('.cat_name').html(cat_name+ ' - ' + result.products_count + ' Item');
            if(result.max_sider>1)
            set_slider(result.max_sider);
            else
            set_slider(10000);
        });
     }     
     // price slider js 
    function set_slider(max){
        //alert(max)
        $('#max-price').text(max)
        $("#range-slider").slider({
            range: true,
            min: 1,
            max: max,
            values: [1, max],
            slide: function(event, ui) {
                $("#low-price").val(ui.values[0]);
                $("#high-price").val(ui.values[1]);
                $("#min-price").text("₹" + ui.values[0]);
                $("#max-price").text("₹" + ui.values[1]);
            
            },
            stop: function(event, ui) {
                // Function to be executed when the user releases the slider
                SearchByCategory();
            }             
        });
    }
    $(function() {
        set_slider("{{$max_p}}");
    });
    
    function resetFilters() {
        // Uncheck all checkboxes with class 'cate'
       var urlParams = new URLSearchParams(window.location.search);
        var excludedCategory = urlParams.get('cat');

        // Uncheck all checkboxes except the one with the excluded category
        $('input.cate:checkbox').each(function() {
            if ($(this).val() !== excludedCategory) {
                $(this).prop('checked', false);
            }
        });

        // Reset price range slider and values
        $("#range-slider").slider("values", [1, 2800]);
        $("#min-price").text("₹1");
        $("#max-price").text("2800");
        $("#low-price").val("");
        $("#high-price").val("");

        $('.product_size').each(function() {
            if ($(this).hasClass('active')) {
                  $(this).removeClass('active')
            }
        });
        SearchByCategory();
    }
 </script>
 </body>

 </html>
