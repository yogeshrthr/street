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
                           <th>Photo</th>
							 <th>Name</th>
							  <th>Designation</th>
                            <th>Ratings</th>
                           <th>Comments</th>
                           <th>Dated</th>
                           <th>Active / Inactive</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                            
                       
                       @php
                                        $i = 0;
                                    @endphp
                                    @if ($testimonials->count() > 0)
                                        @foreach ($testimonials as $list)
                                            @php
                                                $i += 1;
                                               
                                            @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td><img src="../testimonial/{{$list->photo}}"></td>
                            <td>{{$list->name}}</td>
                            <td>{{$list->designation}}</td>
                            <td>{{$list->ratings}}</td>
                            <td>{{$list->comments}}</td>
                            <td>{{date('d-m-Y',strtotime($list->dated))}}</td>
                            
                            <td>
                                <?php
                                if($list->status==1){?>
                                 <button onclick="ChangeStatus('{{$list->testimonial_id}}','{{$list->status}}')" class="btn btn-success btn-sm">Active</button>
                                 <?php }
                                 if($list->status==0){?>
                                 <button onclick="ChangeStatus('{{$list->testimonial_id}}','{{$list->status}}')" class="btn btn-danger btn-sm">Inactive</button>
                                 <?php }?>
                                
                            </td>
                            <td>
							<button onclick="DoEdit('{{$list->testimonial_id}}','{{$list->name}}','{{$list->designation}}','{{$list->ratings}}','{{$list->comments}}','{{$list->photo}}')" class="btn btn-outline-primary">Edit</button>
							<button onclick="deleteModal({{$list->testimonial_id}})"  class="btn btn-outline-danger">Delete</button>
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
                <h3 class="mb-0">Add New </h3>
                <a href=""><button type="button" class="close-btn" data-bs-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button></a>
            </div>
            <div class="modal-body">
               
                    <div class="add-wrap">
                       
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/insert-testimonial')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1"> Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Name"  required>
                    </div>
                    
                  
                   <div class="form-group">
                      <label for="exampleInputName1">Designation</label>
                      <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" required>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Ratings</label>
                      <input type="number" class="form-control" id="ratings" name="ratings" placeholder="Ratings" required>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Comments</label>
                     <textarea style="width:100%;" name="comments" required></textarea>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Upload Photo</label>
                      <input type="file" class="form-control" id="photo" name="photo" required>
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
                <h3 class="mb-0">Edit</h3>
               <a href=""><button type="button" class="close-btn" data-bs-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button></a>
            </div>
            <div class="modal-body">
               
                    <div class="add-wrap">
                       
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/update-testimonial')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1"> Name</label>
                      <input type="hidden" name="testimonial_id" id="testimonial_id">
                      <input type="text" class="form-control" id="name_e" name="name" placeholder="Name"  required>
                    </div>
                    
                  
                   <div class="form-group">
                      <label for="exampleInputName1">Designation</label>
                      <input type="text" class="form-control" id="designation_e" name="designation" placeholder="Designation" required>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Ratings</label>
                      <input type="number" class="form-control" id="ratings_e" name="ratings" placeholder="Ratings" required>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Comments</label>
                     <textarea style="width:100%;" id="comments_e" name="comments" required></textarea>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Upload Photo</label>
                      <input type="file" class="form-control" id="photo_e" name="photo">
                      <input type="hidden" class="form-control" id="old_photo" name="old_photo">
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
                                                   <form action="{{route('Admin/delete-testimonial')}}" method="POST">
                                                      @csrf
                                                      <input type="hidden" id="delete_id" name="testimonial_id">
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
		
		function DoEdit(testimonial_id,name,designation,ratings,comments,photo){
			$('#testimonial_id').val(testimonial_id);
			$('#name_e').val(name);
			$('#designation_e').val(designation);
			$('#ratings_e').val(ratings);
			$('#comments_e').text(comments);
			$('#old_photo').val(photo);
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
      $.post("{{route('Admin/changetestimonialStatus')}}",{id,status:st,'_token':'{{csrf_token()}}'},function(data){
          window.location.reload();
      })
  
    }   
 }		
		
		
		</script>