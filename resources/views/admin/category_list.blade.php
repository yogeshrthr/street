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
							 <th>Banner</th>
                            <th>Category Name</th>
                           <th>Active / Inactive</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                            
                       
                       @php
                                        $i = 0;
                                    @endphp
                                    @if ($categories->count() > 0)
                                        @foreach ($categories as $list)
                                            @php
                                                $i += 1;
                                               
                                            @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td><img src="../uploads/category/{{$list->banner}}"></td>
                            <td>{{$list->title}}</td>
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
							<button onclick="DoEdit('{{$list->id}}','{{$list->title}}','{{$list->banner}}')" class="btn btn-outline-primary">Edit</button>
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
                <h3 class="mb-0">Add New Category</h3>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
               
                    <div class="add-wrap">
                       
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/insert-category')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1">Category Name</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Category Name" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Upload Banner</label>
                      <input type="file" class="form-control" id="banner" name="banner" required>
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
                <h3 class="mb-0">Edit Category</h3>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="feather-x-circle"></i>
                </button>
            </div>
            <div class="modal-body">
               
                    <div class="add-wrap">
                       
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/update-category')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1">Category Name</label>
					  <input type="hidden" id="category_id" name="category_id">
                      <input type="text" class="form-control" id="title_e" name="title" placeholder="Category Name" required>
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
                                                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x-circle"></i></button>
                                             </div>
                                             <div class="modal-body">
                                                <div class="delete-wrap text-center">
                                                   <form action="{{route('Admin/delete-category')}}" method="POST">
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
		<x-footer/>
		
		<script>
		function AddNewModal(){
			$('#AddModal').modal('show');
		}
		
		function DoEdit(id,title,banner){
			$('#category_id').val(id);
			$('#title_e').val(title);
			$('#old_banner').val(banner);
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
      $.post("{{route('Admin/changeCategoryStatus')}}",{id,status:st,'_token':'{{csrf_token()}}'},function(data){
          window.location.reload();
      })
  
    }   
 }	
		</script>