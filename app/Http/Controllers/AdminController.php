<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Testimonial;
use App\Models\Banner;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Order;
use App\Models\Pincode;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function login(){
       
      
        return view('admin.login');
    
    }

    public function branch_login(){
       
        if(session()->has('user_id')){
            return redirect()->route('dashboard');
        }else{
        return view('admin.branch_login');
        }
    }

    
public function loginAuth(Request $data){
   $email=$data->email;
   $password=$data->password;
   $chk=Admin::where('email',$email)->exists();
   if($chk){
    $admin=Admin::where('email',$email)->first();
   if(Hash::check($password,$admin->password)){
     session()->put('user_id',$admin->id);
     session()->put('user_name',$admin->display_name);
     session()->put('user_type','admin');
     return redirect()->route('Admin/dashboard')->with('success','login successfully.');
   }else{
    return redirect()->route('Admin')->with('error','Incorrect Password.');
   }

   }else{
    return redirect()->route('Admin')->with('error','This Email not registered.');
   }

}




public function dashboard(){

    
    if(session()->has('user_id')){
        $products = Product::orderBy('id','DESC')->take(10)->get();
        $orders=Order::orderBy('id','DESC')->take(10)->get();
        
    return view('admin.dashboard',compact(['products','orders']))->render();
    }else{
        return redirect()->route('Admin')->with('error','Login first.'); 
    }
   }   

   public function logout(){
    session()->flush();
    return redirect()->route('Admin');
   }


  // Banners

 public function user_list(){
    if(session()->has('user_id')){
		 $users=User::orderBy('user_id','DESC')->get();
        
		  return view('admin.user_list',compact(['users']))->render();
    }else{
    return redirect()->route('login')->with('error','Login first.');   
    }     
}


public function insert_user(Request $data){
    
    $user_name=$data->user_name;
     $user_email=$data->user_email;
    $user_mobile=$data->user_mobile;
    $password = Hash::make($data->password);
    $pass=$data->password;
    $chkEmail=User::where('user_email',$user_email)->exists();
    $chkMobile=User::where('user_mobile',$user_mobile)->exists();
    if($chkEmail){
        return redirect()->route('Admin/user-list')->with('error','Email   already exist.');
    }else if($chkMobile){
        return redirect()->route('Admin/user-list')->with('error','Mobile Number  already exist.');
    }else{
        $userdata=User::insert(
            [
                'user_name'=>$user_name,
                'user_email'=>$user_email,
                'user_mobile'=>$user_mobile,
                'password'=>$password,
                'pass'=>$pass
                
            ]
        );
		 return redirect()->route('Admin/user-list')->with('success','User Created successfully.');
       
    }
}


public function update_user(Request $data){
    $user_id=$data->user_id;
    $user_name=$data->user_name;
    $user_email=$data->user_email;
    $user_mobile=$data->user_mobile;
      $password = Hash::make($data->password);
	  $pass=$data->password;
	  
	$User=user::where('user_id',$user_id)->update(
    [
    'user_name'=>$user_name,
    'user_email'=>$user_email,
    'user_mobile'=>$user_mobile,
    'password'=>$password,
    'pass'=>$pass
	]
);
   return redirect()->route('Admin/user-list')->with('success','User Details updated successfully.');
}


public function changeUserStatus(Request $data){
    $id=$data->id;
    $status=$data->status;
  
 $User=user::where('user_id',$id)->update(
    [
    'status'=>$status
         
	]
);
   return redirect()->route('Admin/user-list')->with('success','Status change successfully.');
    
}

public function delete_user(Request $data){
    $id=$data->user_id;
    $del=User::where('user_id',$id)->delete();
       return redirect()->back()->with('success','User deleted');
}



 public function testimonial_list(){
    if(session()->has('user_id')){
		 $testimonials=Testimonial::orderBy('testimonial_id','DESC')->get();
        
		  return view('admin.testimonial_list',compact(['testimonials']))->render();
    }else{
    return redirect()->route('login')->with('error','Login first.');   
    }     
}


public function insert_testimonial(Request $data){
    
    $name=$data->name;
     $designation=$data->designation;
     $ratings=$data->ratings;
     $comments=$data->comments;
    $imageFile = $data->file('photo');
        $imageName = time().$imageFile->getClientOriginalName();
        $image = $imageFile->move('testimonial',$imageName);
        $userdata=testimonial::insert(
            [
                'name'=>$name,
                'designation'=>$designation,
                'ratings'=>$ratings,
                'comments'=>$comments,
                'photo'=>$imageName
                
            ]
        );
		 return redirect()->route('Admin/testimonial-list')->with('success','Testimonial Created successfully.');
       
    
}


public function update_testimonial(Request $data){
    $testimonial_id=$data->testimonial_id;
    $name=$data->name;
     $designation=$data->designation;
     $ratings=$data->ratings;
     $comments=$data->comments;
	  
	   $photo = $data->file('photo');
	
	if($photo==''){
		$image= $data->old_photo;
	}else{
            $image = time().$photo->getClientOriginalName();
            $signature_path = $photo->move('testimonial',$image);
	}
	  
	  
	  
	  
	$testi=Testimonial::where('testimonial_id',$testimonial_id)->update(
     [
                'name'=>$name,
                'designation'=>$designation,
                'ratings'=>$ratings,
                'comments'=>$comments,
                'photo'=>$image
                
            ]
);
   return redirect()->route('Admin/testimonial-list')->with('success','Testimonial updated successfully.');
}

public function changetestimonialStatus(Request $data){
    $testimonial_id=$data->id;
    $status=$data->status;
    	$testi=Testimonial::where('testimonial_id',$testimonial_id)->update(
     [
                'status'=>$status
                
                
            ]
);
   return redirect()->route('Admin/testimonial-list')->with('success','Status Change successfully.');
}

public function delete_testimonial(Request $data){
    $id=$data->testimonial_id;
    $del=Testimonial::where('testimonial_id',$id)->delete();
       return redirect()->back()->with('success','Testimonial deleted');
}



   public function category_list(){
    if(session()->has('user_id')){
		 $categories=Category::orderBy('id','DESC')->get();
        
		  return view('admin.category_list',compact(['categories']))->render();
    }else{
    return redirect()->route('login')->with('error','Login first.');   
    }     
}

public function insert_category(Request $data){
    
    $title=$data->title;
   $imageFile = $data->file('banner');
        $imageName = time().$imageFile->getClientOriginalName();
        $image = $imageFile->move('uploads/category',$imageName);
    $chk=Category::where('title',$title)->exists();
    if($chk){
        return redirect()->route('Admin/category-list')->with('error','Category name  already exist.');
    }else{
        $categorydata=Category::insert(
            [
                'title'=>$title,
                'banner'=>$imageName
                
            ]
        );
		 return redirect()->route('Admin/category-list')->with('success','Category Created successfully.');
       
    }
}

public function update_category(Request $data){
    $id=$data->category_id;
    $title=$data->title;
    $banner = $data->file('banner');
	
	if($banner==''){
		$image= $data->old_banner;
	}else{
            $image = time().$banner->getClientOriginalName();
            $signature_path = $banner->move('uploads/category/',$image);
	}
   


 $Category=Category::where('id',$id)->update(
    [
    'title'=>$title,
    'banner'=>$image        
	]
);
   return redirect()->route('Admin/category-list')->with('success','Category updated successfully.');
    
}

public function changeCategoryStatus(Request $data){
    $id=$data->id;
    $status=$data->status;
    $Category=Category::where('id',$id)->update(
    [
    'status'=>$status
   
	]
);
   return redirect()->route('Admin/category-list')->with('success','Status change successfully.');
}


public function delete_category(Request $data){
    $id=$data->category_id;
    $del=Category::where('id',$id)->delete();
       return redirect()->back()->with('success','Category deleted');
}


//Subcategories

 public function subcategory_list(){
    if(session()->has('user_id')){
		 $subcategories=SubCategory::orderBy('id','DESC')->get();
		 $categories=Category::orderBy('id','DESC')->get();
        
		  return view('admin.subcategory_list',compact(['subcategories','categories']))->render();
    }else{
    return redirect()->route('login')->with('error','Login first.');   
    }     
}

public function insert_subcategory(Request $data){
     $category_id=$data->category_id;
    $name=$data->name;
   
    $chk=SubCategory::where('name',$name)->exists();
    if($chk){
        return redirect()->route('Admin/subcategory-list')->with('error','Subcategory name  already exist.');
    }else{
        $subcategorydata=SubCategory::insert(
            [
                'category_id'=>$category_id,
                'name'=>$name
                
            ]
        );
		 return redirect()->route('Admin/subcategory-list')->with('success','Subcategory Created successfully.');
       
    }
}

public function update_subcategory(Request $data){
    $id=$data->subcategory_id;
	 $category_id=$data->category_id;
    $name=$data->name;
   
   


 $Subcategory=SubCategory::where('id',$id)->update(
    [
    'category_id'=>$category_id,
	'name'=>$name
    
	]
);
   return redirect()->route('Admin/subcategory-list')->with('success','subcategory updated successfully.');
    
}

public function changeSubCategoryStatus(Request $data){
     $id=$data->id;
	 $status=$data->status;
     $Subcategory=SubCategory::where('id',$id)->update(
    [
    'status'=>$status

    
	]
);
   return redirect()->route('Admin/subcategory-list')->with('success','status change successfully.');
}

public function delete_subcategory(Request $data){
    $id=$data->subcategory_id;
    $del=SubCategory::where('id',$id)->delete();
       return redirect()->back()->with('success','subcategory deleted');
}




// Banners

 public function banner_list(){
    if(session()->has('user_id')){
		 $banners=Banner::orderBy('id','DESC')->get();
        
		  return view('admin.banner_list',compact(['banners']))->render();
    }else{
    return redirect()->route('login')->with('error','Login first.');   
    }     
}

public function insert_banner(Request $data){
    
    $title=$data->title;
     $banner_url=$data->banner_url;
   $imageFile = $data->file('image');
        $imageName = time().$imageFile->getClientOriginalName();
        $image = $imageFile->move('uploads/banner',$imageName);
    
       
   
        $bannerdata=banner::insert(
            [
                'title'=>$title,
                'banner_url'=>$banner_url,
                'image'=>$imageName
                
            ]
        );
		 return redirect()->route('Admin/banner-list')->with('success','Banner added successfully.');
       
    
}

public function update_banner(Request $data){
    $id=$data->banner_id;
    $title=$data->title;
    $banner_url=$data->banner_url;
    $imageFile = $data->file('image');
	
	if($imageFile==''){
		$image= $data->old_image;
	}else{
            $image = time().$imageFile->getClientOriginalName();
            $signature_path = $imageFile->move('uploads/banner/',$image);
	}
   


 $banner=Banner::where('id',$id)->update(
    [
    'title'=>$title,
    'banner_url'=>$banner_url,
    'image'=>$image        
	]
);
   return redirect()->route('Admin/banner-list')->with('success','Banner updated successfully.');
    
}


public function changeBannerStatus(Request $data){
    $id=$data->id;
    $status=$data->status;
  
 $banner=Banner::where('id',$id)->update(
    [
    'status'=>$status
         
	]
);
   return redirect()->route('Admin/banner-list')->with('success','Banner updated successfully.');
    
}


public function delete_banner(Request $data){
    $id=$data->delete_id;
    $del=Banner::where('id',$id)->delete();
       return redirect()->back()->with('success','Banner deleted');
}


    public function order_list(){
        if(session()->has('user_id')){
            $orders=Order::orderBy('id','DESC')->get();
            $orderIds = array_column($orders->toArray(), 'order_id');

            // Count occurrences of each order ID
            $orderCounts = array_count_values($orderIds);
           // dd($orders->toArray(),$orderIds,$orderCounts,$orderCounts[$orders[0]->order_id]);
            return view('admin.order_list',compact(['orders']))->render();
        }else{
        return redirect()->route('login')->with('error','Login first.');   
        }  
    }
    public function order_details(Request $request){
        if(session()->has('user_id')){
            if(isset($request->order_id) && empty($request->order_id)){
                return back();
            }
            $order=Order::with('stock')->where(['order_id'=>$request->order_id])->get();
            // dd($order->toArray());
            if(!empty($order) && count($order)>0)
            return view('admin.order_details')->with(['details'=>$order]);
            return back()->with('error','Something Went Wrong..');
        }else{
        return redirect()->route('login')->with('error','Login first.');   
        }  
    }


 
    // pincoce managerment 
    public function pincode_list(){
        if(session()->has('user_id')){
            $pincode=Pincode::orderBy('id','DESC')->get();            
            return view('admin.manage_pincode',compact(['pincode']))->render();
        }else{
        return redirect()->route('login')->with('error','Login first.');   
        }     
    }


    public function insert_pincode(Request $data){
        
        $pincode=$data->pincode;
        $userdata=Pincode::insert(
            [
                'pincode'=>$pincode,
                
            ]
        );
        return redirect()->route('Admin/pincode-list')->with('success','Pincode Added successfully.');
        
        
    }


    public function update_pincode(Request $data){
        $pincode_id=$data->pincode_id;
        $pincode=$data->pincode;
        $testi=Pincode::where('id',$pincode_id)->update(
        [
            'pincode'=>$pincode,
                    
        ]
    );
    return redirect()->route('Admin/pincode-list')->with('success','Pincode updated successfully.');
    }

    public function changePincodeStatus(Request $data){
        $pincode_id=$data->id;
        $status=$data->status;
            $testi=Pincode::where('id',$pincode_id)->update(
            [
                'status'=>$status 
            ]
        );
        return redirect()->route('Admin/pincode-list')->with('success','Status Change successfully.');
    }

    public function delete_pincode(Request $data){
        $id=$data->pincode_id;
        $del=Pincode::where('id',$id)->delete();
        return redirect()->back()->with('success','Pincode deleted');
    }

}


