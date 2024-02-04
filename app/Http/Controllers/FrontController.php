<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Stock;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use DB;


class FrontController extends Controller
{
    public function home(){
        $products = Product::
            whereHas('subcategory', function ($categoryQuery) {
                // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                $categoryQuery->where('status', 1);                
            })
            ->whereHas('category', function ($categoryQuery) {
                // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                $categoryQuery->where('status', 1);                
            })
            ->where('status',1)->orderBy('id','ASC')->lazy();
        $new_arrivals = Product::
            whereHas('subcategory', function ($categoryQuery) {
                // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                $categoryQuery->where('status', 1);                
            })
            ->whereHas('category', function ($categoryQuery) {
                // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                $categoryQuery->where('status', 1);                
            })->where('status',1)->orderBy('id','DESC')->lazy();
        $categories = Category::lazy()->where('status',1);
        return view('index')->with(compact(['products','categories','new_arrivals']));
    }
    
    
    public function products(Request $request){
        $cat_id = $request->cat;
        if($request->has('cat') && $request->cat != null && $request->cat != '') {
            $product_list = Product::
                whereHas('subcategory', function ($categoryQuery) {
                    // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                    $categoryQuery->where('status', 1);                
                })
                ->whereHas('category', function ($categoryQuery) {
                    // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                    $categoryQuery->where('status', 1);                
                })->where('status',1)->where('category_id',$cat_id)->orderBy('id','DESC')->get();
            $single_category = Category::where(['id'=>$cat_id,'status'=>1])->first();
        }else {
            $product_list = Product::
                whereHas('subcategory', function ($categoryQuery) {
                    // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                    $categoryQuery->where('status', 1);                
                })
                ->whereHas('category', function ($categoryQuery) {
                    // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                    $categoryQuery->where('status', 1);                
                })->where('status',1)->orderBy('id','DESC')->get();
                    $single_category = null;
                }
        $categories = Category::lazy()->where('status',1);        
        //dd($product_list->toArray());
        return view('products')->with(compact(['product_list','categories','single_category']));
    }
     
     
     public function search_product_by_category(Request $request){

        $categories = $request->category;
        $size_ar = $request->size;
        $sorting = $request->sort;
        $price = $request->price;
        $orderBy = 'id'; // Default value
        $sortDirection = 'desc'; // Default value

        if ($sorting == 3) {
            $orderBy = 'created_at';
            $sortDirection = 'desc';
        } else if ($sorting == 0) {
            $orderBy = 'name';
            $sortDirection = 'asc';
        }

        $products = Product::with(['variations', 'stocks'])
            ->when(!empty($categories), function ($query) use ($categories) {
                // If categories are provided, filter by category
                $query->whereIn('category_id', $categories);
            })
            ->when(!empty($size_ar), function ($query) use ($size_ar) {
                // If size_ar is not empty, filter by size
                $query->whereHas('variations', function ($subQuery) use ($size_ar) {
                    $subQuery->where('variation_type', 'size')
                        ->whereIn('variation_list', $size_ar)
                        ->orWhere(function ($orSubQuery) use ($size_ar) {
                            foreach ($size_ar as $size) {
                                $orSubQuery->orWhereRaw('FIND_IN_SET(?, variation_list)', [$size]);
                            }
                        });
                });
            }) 
            ->whereHas('category', function ($categoryQuery) {
                // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                $categoryQuery->where('status', 1);                
            })
            ->whereHas('subcategory', function ($categoryQuery) {
                // Check if both the category and subcategory statuses are 1 (assuming 1 means active)
                $categoryQuery->where('status', 1);                
            })
            ->where('status', 1)
            ->orderBy($orderBy, $sortDirection)
        ->get();
        //dd($products->toArray());
        $filter_priducts=$products;
        // low to high
        if(!empty($sorting) && $sorting==2){
            $filter_priducts = $filter_priducts->sortBy(function ($item) {
                return $item['stocks']['discount'];
            });
        }
        // high to low
        if(!empty($sorting) && $sorting==1){
            $filter_priducts = $filter_priducts->sortByDesc(function ($item) {
                return $item['stocks']['discount'];
            });
        }

        //price between
        if(!empty($price)){
            $minDiscount=explode('||',$price)[0];
            $maxDiscount=explode('||',$price)[1];
            $filter_priducts = $filter_priducts->filter(function ($item) use ($minDiscount, $maxDiscount) {
                $discount = $item['stocks']['discount'];
                return $discount >= $minDiscount && $discount <= $maxDiscount;
            });
            // dd($filter_priducts->toArray(),$filter_priducts->toArray());
        }
        // // Reset the keys of the filtered collection
        if(isset($filter_priducts) && count($filter_priducts)){
            $products = $filter_priducts->values();
        }else{
            $products = $filter_priducts;
        }

        // get cat name
        $cat=[]; 
        if(!empty($categories))
        $cat=Category::whereIn('id',$categories)->get();

        // return view('product-filter',compact(['products']))->render();

        $html = view('product-filter')->with(['products'=>$products])->render();
        $maxDiscount=0;
        $maxDiscountStocks = $products->pluck('stocks')->filter(function ($stock) use ($maxDiscount) {
            return optional($stock->max('discount'))->discount == $maxDiscount;
        })->flatten();

        $maxDiscountValue = $maxDiscountStocks->max('discount');
       //dd($maxDiscountValue);
        // max value of slider
        
        return response()->json(['html' => $html, 'products_count' => count($products), 'cat' => $cat,'max_sider'=>$maxDiscountValue]);
    }
     
    public function product_details(Request $request){
        $id=$request->id;
        $product = Product::where('id',$id)->first();
            $categories = Category::lazy();
            // dd($categories->toArray());
            return view('product_details')->with(compact(['product']));
    }
    public function get_variation_price(Request $request){
        //dd($request->color,$request->size);
        $records = DB::table('stocks')
            ->where(function ($query) use ($request) {
                $query->whereRaw("CONCAT(variation, ',') LIKE ?", ["%$request->size%,%$request->color%"])
                    ->orWhereRaw("CONCAT(variation, ',') LIKE ?", ["%$request->color%,%$request->size%"]);
            })
            ->where('product_id', $request->product_id)->first();
        if(isset($records->discount)){
            $data['price']=$records->discount;
            $data['stock_id']=$records->id;
            $data['in_stock']=$records->stock;
            return response()->json(['status'=>200,'data'=>$data]);
        } 
        return response()->json(['status'=>400,'price'=>'']);
        
    }
     
}
