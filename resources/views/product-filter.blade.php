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
