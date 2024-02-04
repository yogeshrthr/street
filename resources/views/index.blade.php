<x-front_header />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@php
    $cate = DB::table('categories')
        ->orderBy('id', 'ASC')
        ->first();
@endphp
<section class="slider-section" onclick="closeNavPanel()"
    style="background-image: url('../uploads/category/{{ $cate->banner }}');"></section>
<section class="trending-product-catalogue">
    <div class="container text-center">
        <h4 class="trending-product-catalogue-heading">Shop New Arrivals</h4>
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($categories as $list)
                    <div class="swiper-slide">
                        <div class="product-category-item">
                            <a href="{{ route('products') }}?cat={{ $list->id }}">
                                <div class="content-overlay"></div>
                                <img class="content-image" src="../uploads/category/{{ $list->banner }}" alt="">
                                <div class="content-details fadeIn-top">
                                    <h3>{{ $list->title }}</h3>
                                    <p class="text-decoration-underline">View All Products</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<section class="product-catalogue">
    <div class="container">
        <div class="row">
            @foreach ($products as $pro)
                @php
                    $stock = DB::table('stocks')
                        ->where('product_id', $pro->id)
                        ->orderBy('price', 'ASC')
                        ->first();
                @endphp
                <div class="col-md-4 col-sm-6">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="{{ route('product-details') }}?id={{ $pro->id }}" class="image">
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
                                <a class="add-to-cart" href="{{ route('product-details') }}?id={{ $pro->id }}">
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
<x-front_footer />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        loop: true,
        autoplay: true,
        variableWidth: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 5,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
        },
    });
</script>
