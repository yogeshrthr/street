<x-header />
<x-side_menu />
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive ">

                            <table id="order-listing1" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Order ID</th>
                                        <th>Product Titile</th>
                                        <th>Product Image</th>
                                        <th>Customer Name</th>
                                        <th>Order Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Txn ID </th>
                                        <th>Order Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @if ($orders->count() > 0)
                                        <?php 
                                            $processedOrderIds = null;
                                            $orderIds = array_column($orders->toArray(), 'order_id');
                                            // Count occurrences of each order ID
                                            $orderCounts = array_count_values($orderIds);
                                            //dd($orderCounts,$orders);
                                            ?>
                                        @foreach ($orders as $list)
                                            @php
                                                $i += 1;
                                            @endphp
                                            <?php
                                            $user = DB::table('users')
                                                ->where('user_id', $list->customer_id)
                                                ->first(); ?>
                                                @if(!isset($processedOrderIds[$list->order_id]))
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>  <a target="_blank" href="{{url('admin/order-details')}}?order_id={{$list->order_id}}"> {{ $list->order_id }} </a>{{ $orderCounts[$list->order_id]>1?$orderCounts[$list->order_id]-1:'' }}</td>
                                                <td>{{ $list->product_title }}</td>
                                                <td>  <img src="{{asset($list->product_image)}}" alt="pro_img"></td>
                                                <td>{{ $user->user_name ?? '' }}</td>
                                                <td>{{ $list->price*$list->quantity+50 }}</td>
                                                <td>{{ $list->payment_mode }}</td>
                                                <td>{{ $list->transaction_id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($list->created_at)->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                            <?php  $processedOrderIds[$list->order_id] = true;?>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div>
                </div>
                <div class="modal fade contentmodal" id="AddModal" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content doctor-profile">
                            <div class="modal-header">
                                <h3 class="mb-0">Add New banner</h3>
                                <a href=""><button type="button" class="close-btn" data-bs-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button></a>
                            </div>
                            <div class="modal-body">

                                <div class="add-wrap">

                                    <div class="card-body">

                                        <form class="forms-sample" method="post"
                                            action="{{ route('Admin/insert-banner') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="exampleInputName1">Banner Title</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                    placeholder="Banner title">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputName1">Banner Url</label>
                                                <input type="url" class="form-control" id="banner_url"
                                                    name="banner_url" placeholder="Banner Url">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail3">Upload Banner</label>
                                                <input type="file" class="form-control" id="image" name="image"
                                                    required>
                                            </div>
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                        </form>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade contentmodal" id="EditModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content doctor-profile">
                    <div class="modal-header">
                        <h3 class="mb-0">Edit Banner</h3>
                        <a href=""><button type="button" class="close-btn" data-bs-dismiss="modal">
                                <i class="fa fa-close"></i>
                            </button></a>
                    </div>
                    <div class="modal-body">

                        <div class="add-wrap">

                            <div class="card-body">

                                <form class="forms-sample" method="post" action="{{ route('Admin/update-banner') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName1">Category Name</label>
                                        <input type="hidden" id="banner_id" name="banner_id">
                                        <input type="text" class="form-control" id="title_e" name="title"
                                            placeholder="Baner Name">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName1">Banner Url</label>

                                        <input type="url" class="form-control" id="banner_url_e" name="banner_url"
                                            placeholder="Baner Url">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Upload Banner</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        <input type="hidden" class="form-control" id="old_image" name="old_image">
                                    </div>
                                </form>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade contentmodal" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header border-bottom-0 justify-content-end">
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="feather-x-circle"></i></button>
                </div>
                <div class="modal-body">
                    <div class="delete-wrap text-center">
                        <form action="{{ route('Admin/delete-banner') }}" method="POST">
                            @csrf
                            <input type="hidden" id="delete_id" name="delete_id">
                            <div class="del-icon"><i class="feather-x-circle"></i></div>
                            <h2>Sure you Want to delete</h2>

                            <div class="submit-section">
                                <button type="submit" class="btn btn-success me-2">Yes</button>
                                <a href="#" class="btn btn-danger" data-bs-dismiss="modal">No</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<x-footer />
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

<script>
    function AddNewModal() {
        $('#AddModal').modal('show');
    }

    function DoEdit(id, title, banner_url, banner) {
        $('#banner_id').val(id);
        $('#title_e').val(title);
        $('#banner_url_e').val(banner_url);
        $('#old_image').val(banner);
        $('#EditModal').modal('show');
    }

    function deleteModal(id) {
        $('#delete_id').val(id);
        $('#deleteModal').modal('show');
    }
</script>
<script>
$(document).ready(function () {
    $('#order-listing1').DataTable({
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
        "dom": '<"row"<"col-sm-6"l><"col-sm-6 text-right"f>>rtip',
    });
});

</script>