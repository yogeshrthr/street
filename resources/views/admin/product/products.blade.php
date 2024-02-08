<x-header />
<x-side_menu />
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive ">
                            <button onclick="AddNewModal()" class="btn btn-outline-primary" style="float: right;">+Add
                                New</button>
                                
                                
                                
                         <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>Sl No</th>
                           <th>Image</th>
							 <th>Product Name</th>
							  <th>Category  >> Subcategory</th>
                            <th>Description</th>
                           <th>Active / Inactive</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       @php
                            $i = 0;
                        @endphp
                            @if ($products->count() > 0)
                                @foreach ($products as $list)
                                    @php
                                        $category= DB::table('categories')->where('id', $list->category_id)->first();
                                        $subcategory= DB::table('sub_categories')->where('id', $list->subcategory_id)->first();
                                        $i += 1;
                                       
                                    @endphp
                                <tr>
                                <td>{{$i}}</td>
                                <td><img src="{{$list->image}}"></td>
                                <td>{{$list->name}}</td>
                                <td>{{$category->title}}  >>  {{$subcategory->name}}</td>
                                <td>{{$list->description}}</td>
                                <td>
                                    <?php
                                    if($list->status==1){?>
                                     <button onclick="ChangeStatus('{{$list->id}}','{{$list->status}}')" class="btn btn-success btn-sm">Active</button>
                                     <?php }
                                     if($list->status==0){?>
                                     <button onclick="ChangeStatus('{{$list->id}}','{{$list->status}}')" class="btn btn-danger btn-sm">Inactive</button>
                                     <?php }?>
                                    
                                </td>
                                <td>
                                <button  type="button" product_id="{{$list->id}}" class="edit_product btn btn-outline-primary" data-toggle="modal" data-target="#AddModal">
    							Edit</button>
    							<button   class="btn btn-outline-danger">Delete</button>
    							</td>
                                
                                
                        </tr>
    						 @endforeach
						 @endif
                      </tbody>
                    </table>   
                        </div>
                    </div>
                </div>
                <div>
                </div>
            <div class="modal fade contentmodal show" id="AddModal" role="dialog" aria-labelledby="myModalLabel" style="padding-right: 17px; z-index: 10000;" aria-modal="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content doctor-profile">
                        <div class="modal-header">
                                <h3 class="mb-0" id="add_edit_text"> Add New Product</h3>
                                <a href=""><button type="button" class="close-btn" data-bs-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button></a>
                            </div>
                            <div class="modal-body">
                                <div class="add-wrap">
                                    <div class="card-body">
                                        <form id="add_edit_form" class="forms-sample" method="post"
                                            action="{{ route('store-product') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" class="form-control" id="product_id" name="product_id"
                                                    >
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text" class="form-control" id="product_name" name="name"
                                                    placeholder="Product Name" required>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Category</label>
                                                        <select onchange="appendSubcategories(this)" id="category_id" name="category_id"
                                                            class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Sub Category</label>
                                                        <select name="subcategory_id" id="subcategory_id"
                                                            class="form-control" required>
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Thumbnail Image</label>
                                                        <input id="thumbnail_img" type="file" name="image" accept="image/*"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Gallery Image</label>
                                                        <input id="gallery_img" type="file" name="gallery_image[]" accept="image/*"
                                                            multiple class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Product Description</label>
                                                <textarea name="description" id="product_desc" class="form-control" cols="10" rows="3" required></textarea>
                                            </div>
                                            <div class="row" id="productPriceAndStock">
                                                <div class="col mb-0">
                                                    <div class="form-group">
                                                        <label>Type</label>
                                                        <select onchange="fetchProductPrice(this)" id="" name="product_variation"
                                                            class="form-control" required>
                                                            <option value="Single">Single</option>
                                                            <option value="Variable">Variable</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col mb-0">
                                                    <div class="form-group">
                                                        <label>Price</label>
                                                        <input type="number" class="form-control" name="price"
                                                        placeholder="0.00" required>
                                                    </div>
                                                </div>
                                                <div class="col mb-0">
                                                    <div class="form-group">
                                                        <label>Discount</label>
                                                        <input type="number" class="form-control" name="discount_price"
                                                        placeholder="0.00" required>
                                                    </div>
                                                </div>
                                                <div class="col mb-0">
                                                    <div class="form-group">
                                                        <label>Stock</label>
                                                        <input type="number" class="form-control" name="stock"
                                                        placeholder="e.g : 100" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="attributeNameList"></div>
                                    </div>
                                    <button type="submit" class="btn btn-success mr-2">Add</button>
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
                    <h3 class="mb-0">Edit Category</h3>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="feather-x-circle"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="add-wrap">

                        <div class="card-body">

                            <form class="forms-sample" method="post" action="{{ route('Admin/update-category') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="hidden" id="category_id" name="category_id">
                                    <input type="text" class="form-control" id="title_e" name="title"
                                        placeholder="Category Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Upload Banner</label>
                                    <input type="file" class="form-control" id="banner" name="banner">
                                    <input type="hidden" class="form-control" id="old_banner" name="old_banner">
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
<div class="modal fade contentmodal" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header border-bottom-0 justify-content-end">
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x-circle"></i></button>
            </div>
            <div class="modal-body">
                <div class="delete-wrap text-center">
                    <form action="{{ route('Admin/delete-category') }}" method="POST">
                        @csrf
                        <input type="hidden" id="delete_id" name="category_id">
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
<script src="assets/js/products.js"></script>

<script>
    function AddNewModal() {
        $('#AddModal').modal('show');        
        $('#add_edit_form').removeAttr('action');
        $('#add_edit_text').html('Add New Product')
        $('#add_edit_form').attr('action', "{{ route('store-product') }}")
        $('#product_id').val('')
        $('#gallery_img').attr('required' ,'required');
        $('#thumbnail_img').attr('required', 'required');

    }

    function DoEdit(id, title, banner) {
        $('#category_id').val(id);
        $('#title_e').val(title);
        $('#old_banner').val(banner);
        $('#EditModal').modal('show');
    }

    function deleteModal(id) {
        $('#delete_id').val(id);
        $('#deleteModal').modal('show');
    }
   	function ChangeStatus(id,status){
      if(status==1){ var text="Inactive"; var st=0;}
      if(status==0){ var text="Active"; var st=1;}
    if (confirm('Are you sure  want to '+ text + '?')) {
      $.post("{{route('Admin/changeProductStatus')}}",{id,status:st,'_token':'{{csrf_token()}}'},function(data){
          window.location.reload();
      })
  
    }   
 }	
 
 $(document).ready(function(){
     $('.edit_product').on('click',function(){
         console.log(attributeObj)
         var product_id=$(this).attr('product_id');
         $.ajax({
            url: '/get-produt-details', // Replace with your actual endpoint
            type: 'POST', // or 'GET' depending on your server-side handling
            data: {
                _token:  "{{ csrf_token() }}",
                product_id: product_id // Send the content to be edited
            },
            success: function(response) {
                // Handle the success response, e.g., update the UI
               console.log(attributeObj);
                if(response.status==200){
                     //$('#productPriceAndStock')
                    $('#add_edit_text').html('Edit Product')
                    $('#add_edit_form').removeAttr('action');
                    $('#add_edit_form').attr('action', "{{url('admin/edit-products')}}");
                    $('#gallery_img').removeAttr('required');
                    $('#thumbnail_img').removeAttr('required');

                    $('#product_id').val(response.product.id)
                    $('#category_id').val(response.product.category.id).trigger('change');
                    console.log(response.product.category.id,response.product.subcategory.id)
                    $('#attributeNameList').html(response.variation);
                    $('#subcategory_id').val(response.product.subcategory.id).trigger('change');
                    $('#product_name').val(response.product.name)
                    $('#product_desc').html(response.product.description)
                    attributeObj = response.json_obj ?? {};
                    $('#productPriceAndStock').html(response.product_price)
                     
                }
                
                
                
                console.log('Edit successful:', response);
            },
            error: function(error) {
                // Handle the error response
                console.error('Edit failed:', error);
            }
        });
     })
 })
    
</script>
