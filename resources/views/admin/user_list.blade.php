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
                           
							 <th>Name</th>
							  <th>Email</th>
                            <th>Mobile</th>
                           
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                            
                       
                       @php
                                        $i = 0;
                                    @endphp
                                    @if ($users->count() > 0)
                                        @foreach ($users as $list)
                                            @php
                                                $i += 1;
                                               
                                            @endphp
                        <tr>
                            <td>{{$i}}</td>
                           
                            <td>{{$list->user_name}}</td>
                            <td>{{$list->user_email}}</td>
                            <td>{{$list->user_mobile}}</td>
                            
                            <td>
                                <?php
                                if($list->status==1){?>
                                 <button onclick="ChangeStatus('{{$list->user_id}}','{{$list->status}}')" class="btn btn-success btn-sm">Active</button>
                                 <?php }
                                 if($list->status==0){?>
                                 <button onclick="ChangeStatus('{{$list->user_id}}','{{$list->status}}')" class="btn btn-danger btn-sm">Inactive</button>
                                 <?php }?>
                                
                            </td>
                            <td>
							<button onclick="DoEdit('{{$list->user_id}}','{{$list->user_name}}','{{$list->user_email}}','{{$list->user_mobile}}','{{$list->pass}}')" class="btn btn-outline-primary">Edit</button>
							<button onclick="deleteModal({{$list->user_id}})"  class="btn btn-outline-danger">Delete</button>
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
                <h3 class="mb-0">Add New User</h3>
                <a href=""><button type="button" class="close-btn" data-bs-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button></a>
            </div>
            <div class="modal-body">
               
                    <div class="add-wrap">
                       
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/insert-user')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1">User Name</label>
                      <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name"  required>
                    </div>
                    
                  
                   <div class="form-group">
                      <label for="exampleInputName1">User Email</label>
                      <input type="email" class="form-control" id="user_email" name="user_email" placeholder="User Email" required>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">User Mobile</label>
                      <input type="number" class="form-control" id="user_mobile" name="user_mobile" placeholder="User Mobile" required>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">User Password</label>
                      <input type="text" class="form-control" id="password" name="password" placeholder="User Password" required>
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
                <h3 class="mb-0">Edit User</h3>
               <a href=""><button type="button" class="close-btn" data-bs-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button></a>
            </div>
            <div class="modal-body">
               
                    <div class="add-wrap">
                       
                <div class="card-body">
                 
                  <form class="forms-sample" method="post" action="{{route('Admin/update-user')}}" enctype="multipart/form-data">
				  @csrf
                    <div class="form-group">
                      <label for="exampleInputName1">User Name</label>
                      <input type="hidden" id="user_id" name="user_id">
                      <input type="text" class="form-control" id="user_name_e" name="user_name" placeholder="User Name"  required>
                    </div>
                    
                  
                   <div class="form-group">
                      <label for="exampleInputName1">User Email</label>
                      <input type="email" class="form-control" id="user_email_e" name="user_email" placeholder="User Email" required>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">User Mobile</label>
                      <input type="number" class="form-control" id="user_mobile_e" name="user_mobile" placeholder="User Mobile" required>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">User Password</label>
                      <input type="text" class="form-control" id="password_e" name="password" placeholder="User Password" required>
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
                                                   <form action="{{route('Admin/delete-user')}}" method="POST">
                                                      @csrf
                                                      <input type="hidden" id="delete_id" name="user_id">
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
		
		function DoEdit(user_id,user_name,user_email,user_mobile,pass){
			$('#user_id').val(user_id);
			$('#user_name_e').val(user_name);
			$('#user_email_e').val(user_email);
			$('#user_mobile_e').val(user_mobile);
			$('#password_e').val(pass);
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
      $.post("{{route('Admin/changeUserStatus')}}",{id,status:st,'_token':'{{csrf_token()}}'},function(data){
          window.location.reload();
      })
  
    }   
 }		
		
		</script>