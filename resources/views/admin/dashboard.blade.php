<x-header />
<x-side_menu />
<style>
    .badge {
        background-color: #f2f7f8 !important;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Todays Sale</h4>
                                <div class="d-flex justify-content-between">

                                    <p class="text-muted badge"> 40</p>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-info w-25" role="progressbar" aria-valuenow="40"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Monthly Sale</h4>
                                <div class="d-flex justify-content-between">

                                    <p class="text-muted badge"> 120</p>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-success w-25" role="progressbar" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Product</h4>
                                <div class="d-flex justify-content-between">
                                    <?php
                                    $product_count = DB::table('products')->count();
                                    ?>

                                    <p class="text-muted badge"> {{ $product_count }}</p>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-danger w-25" role="progressbar" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Total Orders</h4>
                                <div class="d-flex justify-content-between">

                                    <p class="text-muted badge"> 1</p>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-warning w-25" role="progressbar" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">

                        <div class="card-body">
                            <h4>Products</h4>
                            <hr>
                            <div class="table-responsive ">

                                {{-- <table id="order-listing1" class="table">
                                    <thead>
                                        <tr>

                                            <th style="font-size:12px;">Image</th>
                                            <th style="font-size:12px;">Product Name</th>
                                            <th style="font-size:12px;">Category >> Subcategory</th>
                                            <th style="font-size:12px;">Price</th>


                                        </tr>
                                    </thead>
                                    <tbody>



                                        @php
                                            $i = 0;
                                        @endphp
                                        @if ($products->count() > 0)
                                            @foreach ($products as $list)
                                                @php
                                                    $category = DB::table('categories')
                                                        ->where('id', $list->category_id)
                                                        ->first();
                                                    $subcategory = DB::table('sub_categories')
                                                        ->where('id', $list->subcategory_id)
                                                        ->first();
                                                    $i += 1;

                                                @endphp
                                                <tr>

                                                    <td><img src="../{{ $list->image }}"></td>
                                                    <td>{{ $list->name }}</td>
                                                    <td>{{ $category->title }} >> {{ $subcategory->name }}</td>
                                                    <td>
                                                        <?php $stock = DB::table('stocks')
                                                            ->where('product_id', $list->id)
                                                            ->orderBy('price', 'ASC')
                                                            ->first();
                                                        echo $stock->price;
                                                        ?>

                                                    </td>



                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table> --}}
                            </div>

                        </div>
                    </div>



                </div>

                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">
                            <h4>Orders</h4>
                            <hr>
                            <div class="table-responsive ">

                                {{-- <table id="order-listing1" class="table">
                                    <thead>
                                        <tr>


                                            <th style="font-size:12px;">Order ID</th>
                                            <th style="font-size:12px;">User Name</th>
                                            <th style="font-size:12px;">Order Amount</th>

                                            <th style="font-size:12px;">Transaction ID </th>

                                            <th style="font-size:12px;">Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                        @php
                                            $i = 0;
                                        @endphp
                                        @if ($orders->count() > 0)
                                            @foreach ($orders as $list)
                                                @php
                                                    $i += 1;

                                                @endphp
                                                <tr>
                                                    <?php
                                                    $user = DB::table('users')
                                                        ->where('user_id', $list->user_id)
                                                        ->first(); ?>

                                                    <td>{{ $list->order_no }}</td>
                                                    <td>{{ $user->user_name }}</td>
                                                    <td>{{ $list->order_amount }}</td>
                                                    <td>{{ $list->transaction_id }}</td>


                                                    <td>{{ date('d-m-Y', strtotime($list->dated)) }}</td>



                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table> --}}
                            </div>

                        </div>
                    </div>


                </div>

            </div>
        </div>




    </div>
    <x-footer />
