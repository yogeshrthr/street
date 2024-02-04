<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Stock;
use App\Models\Variation;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    public function login() {
        if(session()->has('customer')) {
            return redirect()->route('home');
        }else {
            return view('customer.login');
        }
    }

    public function register() {
        if(session()->has('customer')) {
            return redirect()->route('home');
        }else {
            return view('customer.register');
        }
    }

    public function userLogin(Request $request) {
        $email = $request->email;
        $password = $request->password;
        $chk=User::where('user_email',$email)->exists();
        if($chk){
            $user=User::where('user_email',$email)->first();
            if(Hash::check($password,$user->password)){
                session()->put('customer',$user->user_id);
                session()->put('user_name',$user->user_name);
                session()->put('user_type','user');
                session()->flash('success', 'Login Successfully');
                if(session()->has('cart') && session()->has('checkout')) {
                    echo 3;
                }else {
                    echo 1;
                }
            }else{
                echo 0;
            }
        }else{
            echo 2;
        }
    }
    public function userLogout(){
        // Clear the user-related session data
        Session::forget(['customer', 'user_name', 'user_type']);

        // Redirect the user to the desired page after logout
        return redirect()->route('home')->with('success',"Logout Successfully"); // Change 'home' to your desired route
    }
    public function userSignup(Request $request){
        
        $name = $request->name;
        $email = $request->email;
        $mobile = $request->mobile;
        $password = Hash::make($request->password);
        $chkEmail=User::where('user_email',$email)->exists();
        $chkMobile=User::where('user_mobile',$mobile)->exists();
        if($chkEmail){
           echo 0;
        }else if($chkMobile){
           echo 2;
        }else{
           $userdata=DB::table('users')->insertGetId(
                [
                    'user_name'=>$name,
                    'user_mobile'=>$mobile,
                    'user_email'=>$email,
                    'password'=>$password
                ]
            );
        // $userId = DB::table('users')->insertGetId($userdata);
        //dd($userdata);
        session()->put('customer',$userdata);
        session()->put('user_name',$name);
        session()->put('user_type','user');
        echo 1;
       }
    }

    public function add_to_cart(Request $request)
    {
        $id = $request->product_id;
        $price = $request->price;
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
    
        // Create a unique key for each product and variation
        $cartKey = $id . '_' . $request->stock_id;
    
        if (isset($cart[$cartKey])) {
            // If the same product with the same variation is already in the cart,
            // increase the quantity and update the price
            $cart[$cartKey]["quantity"] += $request->quentity;
            $cart[$cartKey]["price"] = $price * $cart[$cartKey]["quantity"];
        } else {
            // If it's a different variation or a new product, add a new entry
            $stock = Stock::find($request->stock_id)->stock;
    
            $cart[$cartKey] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => $request->quentity,
                "price" => $price * $request->quentity,
                "image" => $product->image,
                "stock_id" => $request->stock_id,
                "stock" => $stock
            ];
        }
    
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    
    public function update_cart(Request $request)
    {
        if($request->id && $request->quantity){            
            $cart = session()->get('cart');
            // if($request->quantity>$cart[$request->id]['stock']){                               
            //     session()->flash('error', "You can't add max qnty to left products.");
            // }else{
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                session()->flash('success', 'Cart updated successfully');
            // }
            
        }
    }

    public function remove_cart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
    
    public function count_cart(){
        $cart = session()->get('cart');
        $counter=count($cart);
        echo $counter;
        
    }
    
    public function cart_list()
    {
        if(session()->has('cart')) {
            return view('cart');
        }else {
            return redirect()->route('home');
        }
    }
    
    public function checkout()
    {
        if(session()->has('cart') && count(session('cart'))) {
            if(session()->has('customer')) {
                $customerExists = User::where('user_id',session('customer'))->exists();
                if($customerExists) {
                    $customer = User::where('user_id',session('customer'))->first();
                    return view('checkout')->with(compact(['customer']));
                }else {
                    session()->put('checkout',session('cart'));
                    return redirect()->route('login');
                }
            }else {
                session()->put('checkout',session('cart'));
                return redirect()->route('login');
            }
        }else {
            return redirect()->route('home');
        }
    }

   
}
