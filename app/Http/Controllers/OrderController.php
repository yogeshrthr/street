<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pincode;
use App\Models\Stock;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    
    
    public function placeOrder(Request $request) {
         if(!(session()->has('customer') && session()->has('cart'))) {
             return back();
         }
        //dd($request->all(),session('cart'));
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'pin_code' => 'required|string|max:10',
            'payment_mode' => 'required|string|max:255',
        ], [
            'required' => 'The :attribute field is required.',
            'email' => 'Please enter a valid email address.',
            'max' => 'The :attribute field must not exceed :max characters.',
        ]);

        try {
           
                $order_id = Str::random(6);
                $customer_id = session('customer');
                $name = $request->name;
                $email = $request->email;
                $phone = $request->phone;
                $address = $request->address;
                $state = $request->state;
                $city = $request->city;
                $pin_code = $request->pin_code;
                $payment_mode = $request->payment_mode;
                foreach(session('cart') as $id => $details) {
                    $price = (float) $details['price'];
                    $quantity = (int) $details['quantity'];
                    $product_id = $details['id'];
                    $product_title = $details['name'];
                    $product_image = $details['image'];
                    Order::create(
                        [
                            'order_id' => $order_id,
                            'customer_id' => $customer_id,
                            'name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'address' => $address,
                            'state' => $state,
                            'city' => $city,
                            'pin_code' => $pin_code,
                            'payment_mode' => $payment_mode,
                            'price' => $price,
                            'quantity' => $quantity,
                            'product_id' => $product_id,
                            'product_title' => $product_title,
                            'product_image' => $product_image,
                            'stock_id' => $details['stock_id']
                        ]
                    );
                    $stock=Stock::find($details['stock_id']);
                    if($stock->stock>=$quantity){
                        $stock->stock=$stock->stock-$quantity;
                        $stock->save();
                    }else{
                        return back()->with('error',"You can Order Maxumn $stock->stock pc Only...");
                    }
                    
                }
                session()->forget('cart');
                if($payment_mode == 'online') {
                    return redirect()->route('pay',['order_id' => $order_id]);
                }else {
                    return view('order_placed')->with(['order_id'=>$order_id]);
                    // return redirect()->route('home')->with('success', 'You Orde is Placed Successfully!');
                }
            

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while processing the order: ' . $e->getMessage());
        }
    }

    private function generatePaymentRequest(String $token) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/v2/payment_requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '.$token));

        $payload = [
            'purpose' => 'FIFA 16',
            'amount' => '2500',
            'buyer_name' => 'John Doe',
            'email' => 'foo@example.com',
            'phone' => '9999999999',
            'redirect_url' => 'http://www.example.com/redirect/',
            'send_email' => 'True',
            'webhook' => 'http://www.example.com/webhook/',
            'allow_repeated_payments' => 'False',
        ];

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        var_dump($response);

    }

    private function generateAccessToken() {
        $grant_type = env("INSTAMOJO_GRANT_TYPE");
        $client_id = env("INSTAMOJO_CLIENT_ID");
        $client_secret = env("INSTAMOJO_CLIENT_SECRET");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.instamojo.com/oauth2/token/');     
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $payload = Array(
            'grant_type' => $grant_type,
            'client_id' => $client_id,
            'client_secret' => $client_secret
        );

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch); 
        
        $response = json_decode($response, true);
        $token = $response['access_token'];
        $this->generatePaymentRequest($token);
    }

    public function pay(Request $request) {
        $order_id = $request->order_id;
        $orders = Order::where('order_id',$order_id)
        ->get(['order_id','price','quantity']);
        $amount = 0;
        foreach($orders as $order) {
            $price = (float) $order->price;
            $quantity = (int) $order->quantity;
            $amount = $amount + ($price * $quantity);
        }
        $this->generateAccessToken();
    }

    // check pincode deliverable or not form admin side
    public function check_pincode(Request $request){
        $pincode=Pincode::where('pincode',$request->pincode)->first();
        //dd($pincode);
        if(!empty($pincode)){
            return response()->json(['status'=>200, 'message'=> 'Pincode Is Vlaid']);
        }else{
            return response()->json(['status'=>400, 'message'=> 'In Vlaid']);
        }
    }
    public function orderSuccess(Request $request){
        
        dd($this->order_placed);
        if(empty($this->order_placed)){
            return redirect('/');
        }else{
            return view('order_placed')->with(['order_id'=>$this->order_placed]);
        }
    }
}
