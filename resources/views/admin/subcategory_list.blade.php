<x-header/>
<x-side_menu/>





<div class="main-panel">
        <div class="content-wrapper">
          
					<div class="row">
            <div class="col-12">
			
			<div class="card">
                <div class="card-body">
			<div class="table-responsive ">
			<button onclick="AddNewModal()" class="btn btn-outline-primary" style="float: right;">+Add New</button>
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>Sl No</th>
							
                            <th>Category Name</th>
                            <th>Sub category Name</th>
                             <th>Active / Inactive</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                            
                       
                       @php
                                        $i = 0;
                                    @endphp
                                    @if ($subcategories->count() > 0)
                                        @foreach ($subcategories as $list)
                                            @php
                                                $i += 1;
                                               
                                            
										
											$category = DB::table('categories')->where('id', $list->category_id)->first();
										@endphp
                        <tr>
                            <td>{{$i}}</td>
                             <td>{{$category->title}}</td>
                            <td>{{$list->name}}</td>
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
							<button onclick="DoEdit('{{$list->id}}','{{$list->category_id}}','{{$list->name}}')" class="btn btn-outline-primary">Edit</button>
							<button onclick="deleteModal({{$list->id}})"  class="btn btn-outline-danger">Delete</button>
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
			
			
			
			
			
			
			
			
			
			
			
					
					
					
					
		<div class="modal fade contentmodal" id="AddModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header">
                <h3 class="mb-0">Add  Sub-Category</h3>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="feather-x-circle"></i>
                </button>
            </div>
            <div class="modal-body">
               
                    <div class="add-wrap">
                       
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/insert-subcategory')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1">Select Category </label>
                    <select name="category_id" id="category_id" class="form-control" required>
					<option value="">--------------------------------------------Select-------------------------------------</option>
					    @foreach ($categories as $cat)
                              <option value="{{$cat->id}}"> {{$cat->title}} </option>
						@endforeach
							
					</select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Sub Category Name </label>
                      <input type="text" class="form-control" id="name" name="name" required>
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
                <h3 class="mb-0">Edit Sub-Category</h3>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="feather-x-circle"></i>
                </button>
            </div>
            <div class="modal-body">
               
                    <div class="add-wrap">
                       
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/update-subcategory')}}" enctype="multipart/form-data">
				  @csrf
                     <div class="form-group">
					  <input type="hidden" class="form-control" id="subcategory_id" name="subcategory_id">
                      <label for="exampleInputName1">Select Category </label>
                    <select name="category_id" id="category_id_e" class="form-control" required>
					<option value="">--------------------------------------------Select-------------------------------------</option>
					    @foreach ($categories as $cat)
                              <option value="{{$cat->id}}"> {{$cat->title}} </option>
						@endforeach
							
					</select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Sub Category Name </label>
                      <input type="text" class="form-control" id="name_e" name="name" required>
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
                                                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x-circle"></i></button>
                                             </div>
                                             <div class="modal-body">
                                                <div class="delete-wrap text-center">
                                                   <form action="{{route('Admin/delete-subcategory')}}" method="POST">
                                                      @csrf
                                                      <input type="hidden" id="delete_id" name="subcategory_id">
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
		<x-footer/>
		
		<script>
		function AddNewModal(){
			$('#AddModal').modal('show');
		}
		
		function DoEdit(id,category_id,name){
			$('#subcategory_id').val(id);
			$('#category_id_e').val(category_id);
			$('#name_e').val(name);
			$('#EditModal').modal('show');
		}
		
		function deleteModal(id){
			$('#delete_id').val(id);
			$('#deleteModal').modal('show');
		}
		
	function ChangeStatus(id,status){
      if(status==1){ var text="Inactive"; var st=0;}
      if(status==0){ var text="Active"; var st=1;}
    if (confirm('Are you sure  want to '+ text + '?')) {
      $.post("{{route('Admin/changeSubCategoryStatus')}}",{id,status:st,'_token':'{{csrf_token()}}'},function(data){
          window.location.reload();
      })
  
    }   
 }			
		
		</script>