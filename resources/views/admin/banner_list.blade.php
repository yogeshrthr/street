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
							  <th>Title</th>
                            <th>Banner Url</th>
                           <th>Active / Inactive</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                            
                       
                       @php
                                        $i = 0;
                                    @endphp
                                    @if ($banners->count() > 0)
                                        @foreach ($banners as $list)
                                            @php
                                                $i += 1;
                                               
                                            @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td><img src="../uploads/banner/{{$list->image}}"></td>
                            <td>{{$list->title}}</td>
                            <td>{{$list->banner_url}}</td>
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
							<button onclick="DoEdit('{{$list->id}}','{{$list->title}}','{{$list->banner_url}}','{{$list->image}}')" class="btn btn-outline-primary">Edit</button>
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
			
			
			
			
			
			
			
			
			
			
			
					
					
					
					
		<div class="modal fade contentmodal" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/insert-banner')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1">Banner Title</label>
                      <input type="text" class="form-control" id="title" name="title" placeholder="Banner title" >
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputName1">Banner Url</label>
                      <input type="url" class="form-control" id="banner_url" name="banner_url" placeholder="Banner Url">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Upload Banner</label>
                      <input type="file" id="" class="form-control" id="image" name="image" required onchange="loadFile(event)">
                      <img id="AddOutput" class="img-thumbnail"/>
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
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/update-banner')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1">Category Name</label>
					  <input type="hidden" id="banner_id" name="banner_id">
                      <input type="text" class="form-control" id="title_e" name="title" placeholder="Baner Name" >
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputName1">Banner Url</label>
				
                      <input type="url" class="form-control" id="banner_url_e" name="banner_url" placeholder="Baner Url" >
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputEmail3">Upload Banner</label>
                      <input type="file" class="form-control" id="image" name="image" onchange="loadFileEdit(event)">
                      <img id="img" class="img-thumbnail">
					  <input type="hidden" class="form-control" id="old_image" name="old_image">
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
                                                   <form action="{{route('Admin/delete-banner')}}" method="POST">
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
		<x-footer/>
		
		<script>
		function AddNewModal(){
			$('#AddModal').modal('show');
		}
		
		function DoEdit(id,title,banner_url,banner){
			$('#banner_id').val(id);
			//alert(banner);
			$('#title_e').val(title);
			$('#banner_url_e').val(banner_url);
			$('#old_image').val(banner);
			document.getElementById("img").src="../uploads/banner/"+banner;
		
			$('#EditModal').modal('show');
		}
		
		function deleteModal(id){
			$('#delete_id').val(id);
			$('#deleteModal').modal('show');
		}
		</script>
		
		<script>
  var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('AddOutput');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>

	<script>
  var loadFileEdit = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('img');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };
  
  function ChangeStatus(id,status){
      if(status==1){ var text="Inactive"; var st=0;}
      if(status==0){ var text="Active"; var st=1;}
    if (confirm('Are you sure  want to '+ text + '?')) {
      $.post("{{route('Admin/changeBannerStatus')}}",{id,status:st,'_token':'{{csrf_token()}}'},function(data){
          window.location.reload();
      })
  
    }   
 }
  
</script>




