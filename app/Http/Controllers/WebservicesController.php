<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Student;

use App\Models\Course;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Material;
use App\Models\Usercourse;
use App\Models\Classes;

use App\Models\Question;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;




class WebservicesController extends Controller
{
    public function StudentLogin(Request $request){
        $email=$request->email;
       $password=$request->password;
       if($email=='' && $password==''){
        $data['code']=0;
        $data['message']="Required all fields.";
        return $data;
       }else{
   $chk=Student::where('email',$email)->exists();
   if($chk){
    $student=Student::where('email',$email)->first();
   if(Hash::check($password,$student->password)){
     
    $data['code']=1;
    $data['message']="Login Succesfully";
    $data['data']=$student;
    return $data;
     
   }else{
    $data['code']=0;
    $data['message']="Incorrect  Login details";
    return $data;
   }

   }else{
    $data['code']=0;
    $data['message']="Email Id not registered.";
    return $data;
   }
       }
    }

public function student_register(Request $request){
   $name=$request->name;
   $email=$request->email;
   $mobile=$request->mobile;
   $password=$request->password;
   $guardian_name=$request->guardian_name;
   $dob=$request->dob;
   $qualification=$request->qualification;
   $address=$request->address;
   if($name!='' && $email!='' && $mobile!='' && $password!='' && $guardian_name!='' && $dob!='' && $qualification!='' && $address!=''){
    $chk_email=Student::where('email',$email)->exists();
    $chk_mobile=Student::where('mobile',$mobile)->exists();
    if($chk_email){
        $data['code']=0;
        $data['message']="Email ID already exist";
        return $data;
    }else if($chk_mobile){
        $data['code']=0;
        $data['message']="Mobile Number already exist";
        return $data;
    }else{
        $dated=date('Y-m-d');
        $pass = Hash::make($password);
        $student_id = random_int(100000,999999);
        if(is_uploaded_file($_FILES['photo']['tmp_name'])){
            $photo=rand(0,9999).$_FILES['photo']['name'];
            @move_uploaded_file($_FILES['photo']['tmp_name'],'uploads/profile/'.$photo);
        }else{
            $photo="";
        }

        $sdata=Student::insert([

            'exam_id'=>0,
            'branch_id'=>0,
            'student_id'=>$student_id,
            'name'=>$name,
            'email'=>$email,
            'mobile'=>$mobile,
            'qualification'=>$qualification,
            'dob'=>$dob,
            'guardians_name'=>$guardian_name,
            'password'=>$pass,
            'address'=>$address,
            'photo'=>$photo,
            'dated'=>$dated
        ]);
        $data['code']=1;
        $data['message']="Student Registeration successfully done.";
        return $data;

    }
   }else{
    $data['code']=0;
    $data['message']="Required all fields";
    return $data;
   }


}

public function myProfile(Request $request){
   $student_id=$request->student_id;
   
   if($student_id){
    $chk_student=Student::where('id',$student_id)->exists();
    if($chk_student){
        $student=Student::where('id',$student_id)->first();
        $studentdata['student_id']=$student->id;
        $studentdata['name']=$student->name;
        $studentdata['email']=$student->email;
        $studentdata['mobile']=$student->mobile;
        $studentdata['guardian_name']=$student->guardians_name;
        $studentdata['address']=$student->address;
        $studentdata['dob']=$student->dob;
        $studentdata['qualification']=$student->qualification;
        if($student->photo!=''){
        $studentdata['photo']='https://galaxy.mitracsindia.in/uploads/profile/'.$student->photo;
        }else{
            $studentdata['photo']="";
        }

        $data['code']=1;
        $data['message']="Profile details available";
        $data['data']=$studentdata;
        return $data;
        
    }else{
        $data['code']=0;
        $data['message']="No Student found";
        return $data;
    }

   }else{
    $data['code']=0;
    $data['message']="Required student_id";
    return $data;
   }
}

public function changePassword(Request $request){
    $student_id=$request->student_id;
    $old_password=$request->old_password;
    $new_password=$request->new_password;

    if($student_id!='' && $old_password!='' && $new_password!=''){
        $chk_student=Student::where('id',$student_id)->exists();
        if($chk_student){
            $student=Student::where('id',$student_id)->first();
            if(Hash::check($old_password,$student->password)){
                $pass = Hash::make($new_password);
                $sdata=Student::where('id',$student_id)->update([
                     'password'=>$pass
                                    
                    ]);
                    $data['code']=1;
                    $data['message']="Password change successfully";
                   return $data;

            }else{
                $data['code']=0;
                $data['message']="Old Password doen not match";
               return $data;
            }
        }else{
            $data['code']=0;
            $data['message']="No Student Found";
           return $data;
        }
    }else{
        $data['code']=0;
        $data['message']="Required all fields";
       return $data;
    }
}

public function forgot_password(Request $request){
    $email=$request->email;
    if($email!=''){
        $chk_email=Student::where('email',$email)->exists();
        if($chk_email){
            $student=Student::where('email',$email)->first();
            $token = Str::random($student->id+10);


            $sdata=Student::where('email',$email)->update([

                'token'=>$token       
            ]);

            $data['code']=1;
            $data['message']="Password Reset Link sent on your email";
            $data['token']=$token;
            return $data;

        }else{
            $data['code']=0;
            $data['message']="Email Id not registered";
            return $data; 
        }
    }else{
        $data['code']=0;
        $data['message']="Required Email Id";
        return $data;
    }

}


public function edit_profile(Request $request){
    $student_id=$request->student_id;
    $name=$request->name;
    $email=$request->email;
    $mobile=$request->mobile;
    $guardian_name=$request->guardian_name;
    $dob=$request->dob;
    $qualification=$request->qualification;
    $address=$request->address;
    if($student_id!=''&& $name!='' && $email!='' && $mobile!='' && $guardian_name!='' && $dob!='' && $qualification!='' && $address!=''){
        $student=Student::where('id',$student_id)->first();
        


        $sdata=Student::where('id',$student_id)->update([
                        
            'name'=>$name,
            'email'=>$email,
            'mobile'=>$mobile,
            'qualification'=>$qualification,
            'dob'=>$dob,
            'guardians_name'=>$guardian_name,
            'address'=>$address,
            
            
        ]);

        $data['code']=1;
        $data['message']="Profile Updated successfully";
        return $data;


    }else{
        $data['code']=0;
        $data['message']="Required Fields";
        return $data; 
    }
}

public function courseList(){
    $courses=Course::orderBy('id','DESC')->get();
    $finaldata=array();
    foreach($courses as $list){
        $coursedata['course_id']=$list->id;
        $coursedata['course_name']=$list->title;
        $coursedata['course_fee']=$list->fee;
        if($list->description==''){
            $coursedata['about_course']="";
        }else{
        $coursedata['about_course']=$list->description;
        }
        if($list->image==''){
            $coursedata['image']="http://127.0.0.1:8000/uploads/course/".$list->image;
        }else{
        $coursedata['image']="http://127.0.0.1:8000/uploads/course/no_image.jpg";
        }
        array_push($finaldata,$coursedata);
    }
    if(!empty($finaldata)){
        $data['code']=1;
        $data['message']="Course list available";
        $data['course_list']=$finaldata;
        return $data;
    }else{
        $data['code']=0;
        $data['message']="Course not found.";
        return $data;
    }
}

public function subjectList(Request $request){
    $course_id=$request->course_id;
  if($course_id==''){
        $data['code']=0;
        $data['message']="Required course ID.";
        return $data;
  }else{
    $chk_course=Course::where('id',$course_id)->exists();
    if($chk_course){
        $course=Course::where('id',$course_id)->first();
        $coursedata['course_id']=$course->id;
        $coursedata['course_name']=$course->title;
        $coursedata['course_fee']=$course->fee;
        $coursedata['subject_list']=array();
        $subjects=Subject::where('course_id',$course_id)->get();
        foreach($subjects as $sub){
            $subjectdata['subject_id']=$sub->id;
            $subjectdata['subject_name']=$sub->subject_name;
            $subjectdata['about_subject']=$sub->description;
            $subjectdata['subject_fee']=$sub->fee;
            $subjectdata['matrial_list']=array();
            $matrials=Material::where('subject_id',$sub->id)->get(); 
             foreach($matrials as $mt){
                $mdata['material_id']=$mt->id;
                $mdata['material_title']=$mt->title;
                if($mt->material!=''){
                $mdata['material_file']='http://127.0.0.1:8000/uploads/material/'.$mt->material;
                }else{
                    $mdata['material_file']="";
                }
                array_push($subjectdata['matrial_list'],$mdata);
             }
         array_push($coursedata['subject_list'],$subjectdata);
        }
        $data['code']=1;
        $data['message']="Subject list found.";
        $data['data']=$coursedata;
        return $data; 
    }else{
        $data['code']=0;
        $data['message']="Course Not found.";
        return $data; 
    }
  }
}


public function chapterList(Request $request){
    $course_id=$request->course_id;
    $subject_id=$request->subject_id;
  if($course_id=='' && $subject_id==''){
        $data['code']=0;
        $data['message']="Required course ID & Subject ID.";
        return $data;
  }else{
    $chk_chapter=Chapter::where('course_id',$course_id)->where('subject_id',$subject_id)->exists();
    if($chk_chapter){
        $chapters=Chapter::where('course_id',$course_id)->where('subject_id',$subject_id)->get();
        foreach($chapters as $list){
        $chapterdata['chapter_id']=$list->id;
        $chapterdata['chapter_title']=$list->title;
        
        $final=array();
        
         array_push($final,$chapterdata);
        }
        $data['code']=1;
        $data['message']="Chapter list found.";
        $data['data']=$final;
        return $data; 
    }else{
        $data['code']=0;
        $data['message']="Chapter Not found.";
        return $data; 
    }
  }
}
public function questionList(Request $request){
   $course_id=$request->course_id;
   $subject_id=$request->subject_id;
   $chapter_id=$request->chapter_id;

   
    $questions=Question::where('course_id',$course_id)->get();
    $final=array();
    foreach($questions as $list){
        $qdata['question_id']=$list->id;
        $qdata['question']=strip_tags(base64_decode($list->question));
        $qdata['option1']=strip_tags(base64_decode($list->option1));
        $qdata['option2']=strip_tags(base64_decode($list->option2));
        $qdata['option3']=strip_tags(base64_decode($list->option3));
        $qdata['option4']=strip_tags(base64_decode($list->option4));
        array_push($final,$qdata);
    }
    if(empty($final)){
        $data['code']=0;
        $data['message']="no question found.";
      
        return $data; 
    }else{
    $data['code']=1;
    $data['message']="question available.";
    $data['question_list']=$final;
    return $data; 
    }

}

public function applyCourse(Request$request){
    $dated=date('Y-m-d');
   $course_id=$request->course_id;
   if($course_id==''){$course_id=0;}
   $subject_id=$request->subject_id;
   if($subject_id==''){$subject_id=0;}
   $chapter_id=$request->chapter_id;
   if($chapter_id==''){$chapter_id=0;}
   $user_id=$request->user_id;
   $fee=$request->fee;

   if($course_id=='' || $user_id==''){
    $data['code']=0;
    $data['message']="Required CourseId.";
     return $data; 
   }else{
    $applycourse=Usercourse::insert(
        [
            'course_id'=>$course_id,
            'subject_id'=>$subject_id,
            'chapter_id'=>$chapter_id,
            'user_id'=>$user_id,
            'fee'=>$fee,
            'dated'=>$dated
        ]
    );

    $data['code']=1;
    $data['message']='Course Applied suuccessfully';
    return $data;
   }
}


public function myCourses(Request $request){
  $user_id=$request->user_id;
  if($user_id==''){
    $data['code']=0;
    $data['message']='Required User ID';
    return $data;
  }else{
    $chk_course=Usercourse::where('user_id',$user_id)->exists();
    if($chk_course){
        $courses=Usercourse::where('user_id',$user_id)->orderBy('dated','DESC')->get();
        $final=array();
        foreach($courses as $list){
           $coursedata['id']=$list->id;
           $coursedata['course_id']=$list->course_id;
           $coursedata['subject_id']=$list->subject_id;
           $coursedata['chapter_id']=$list->chapter_id;
           $coursedata['course_fee']=$list->fee;
           $coursedata['dated']=date('d-m-Y',strtotime($list->dated));
          array_push($final,$coursedata);

        }
        $data['code']=1;
        $data['message']='Course List available';
        $data['course_list']=$final;
        return $data;
    }else{
        $data['code']=0;
        $data['message']='No data found';
        
        return $data;
    }
  }
}


public function myClasses(Request $request){
    $student_id=$request->student_id;
    if($student_id==''){
      $data['code']=0;
      $data['message']='Required Student ID';
      return $data;
    }else{
      $chk_student=Student::where('id',$student_id)->exists();
      if($chk_student){
        $student=Student::where('id',$student_id)->first();
          $student_branch=Branch::where('id',$student->branch_id)->first();

          $classes=Classes::where('course_id',$student->course_id)->where('branch_id',$student->branch_id)->orderBy('class_date','DESC')->get();
          $final=array();
          foreach($classes as $list){
            $chk_course_apply=Usercourse::where('user_id',$student_id)->where('course_id',$list->course_id)->exists();
            if($chk_course_apply){
            $course=Course::where('id',$list->course_id)->first();
             $classdata['id']=$list->id;
             $classdata['course_id']=$list->course_id;
             $classdata['course_name']=$course->title;
             $classdata['class_date']=$list->class_date;
             $classdata['class_time']=date('h:i A',strtotime($list->class_time));
             $classdata['video_link']=$list->video_link;
            
            array_push($final,$classdata);
        }
          }
          if(!empty($final)){
          $data['code']=1;
          $data['message']='Class List available';
          $data['class_list']=$final;
          return $data;
          }else{
            $data['code']=0;
            $data['message']='No data found';
            return $data;
          }
      }else{
          $data['code']=0;
          $data['message']='No data found';
          
          return $data;
      }
    }
  }

}


 