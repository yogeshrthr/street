<x-header />
<x-side_menu />
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

<div class="main-panel">
    <div class="content-wrapper">
       <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="text-muted mb-3">Ordered Items</h5>
                            </div>
                            <div>
                                <form action="https://thepaulscreation.com/update-order-status" method="POST">
                                    <input type="hidden" name="_token" value="9AyaJtDdBX25toQ92R63Sr9VO81Qc1iuOPBDibE8" autocomplete="off">
                                    <input type="hidden" name="order_id" value="OH90L9">
                                    <div class="d-flex justify-content-end mb-3">
                                        <button type="button" class="btn btn-outline-primary me-2">
                                            <i class="ti ti-clock"></i> {{$details[0]->created_at}}
                                        </button>
                                        <a href="https://thepaulscreation.com/generate-invoice?order_id=OH90L9" class="btn btn-primary me-2">
                                            <i class="ti ti-download"></i> Download Invoice
                                        </a>
                                        <div class="me-2">
                                            <select name="status" class="form-control form-select" required="">
                                                <option value="">Select Status</option>
                                                <option selected="" value="Processing">Processing</option>
                                                <option value="Shipped">Shipped</option>
                                                <option value="Delivered">Delivered</option>
                                            </select>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="text-center">
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Discount Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                    <?php $total=0;
                                    //dd($details->toArray());
                                    ?> 
                                    @foreach ($details as $item)                                  
                                    <tr>
                                        <td class="mx-auto text-center">
                                            <img src="{{asset($item->product_image)}}" style="width: 50px; object-fit: cover;">
                                        </td>
                                        <td>
                                            <a href="{{ url('product-details')}}?id={{$item->product_id}}">
                                               {{$item->product_title}}
                                            </a>
                                        </td>
                                        <td>₹{{$item->stock->price}}</td>
                                        <td>₹{{$item->stock->discount}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>₹{{ number_format($item->quantity * $item->stock->discount, 2) }}<td>
                                    </tr>
                                        <?php $total=$total+($item->quantity * $item->stock->discount); ?>
                                     @endforeach
                                    <tr>
                                        <td class="text-end fw-bolder" colspan="5">Sub Total</td>
                                        <td class="fw-bolder">₹{{ number_format($total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end fw-bolder" colspan="5">Shipping Charge</td>
                                        <td class="fw-bolder">+ ₹50.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end fw-bolder" colspan="5">Coupon Discount</td>
                                        <td class="fw-bolder">- ₹0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end fw-bolder" colspan="5">Grand Total</td>
                                        <td class="fw-bolder">₹{{ number_format($total +50, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h5 class="text-muted mb-3">Delivery Details</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="text-center">Full  Name</th>
                                        <td colspan="3" class="text-start">{{ ucfirst($details[0]->name) }}</td>
                                        
                                    </tr>
                                    <tr>
                                        <th class="text-center">Email</th>
                                        <td class="text-start">{{ ($details[0]->email) }}</td>
                                        <th class="text-center">Phone Number</th>
                                        <td class="text-start">{{ $details[0]->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Country</th>
                                        <td class="text-start">India</td>
                                        <th class="text-center">State</th>
                                        <td class="text-start">{{ ($details[0]->state) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">City</th>
                                        <td class="text-start">{{ $details[0]->city }}</td>
                                        <th class="text-center">PIN Code</th>
                                        <td class="text-start">{{ $details[0]->pin_code }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Address Line </th>
                                        <td class="text-start" colspan="3">{{ ucfirst($details[0]->address) }},&nbsp;{{$details[0]->city}}, &nbsp; {{$details[0]->state}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h5 class="text-muted mb-3">Payment Details</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="text-start">Payment Mode</th>
                                        <td class="text-start">Cash On Delivery</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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