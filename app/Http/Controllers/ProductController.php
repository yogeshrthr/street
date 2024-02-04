<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Stock;
use App\Models\Variation;

class ProductController extends Controller
{
    public function get_product_details(Request $request){
        $product=Product::with(['category','variations','all_stocks','subcategory'])->find(13);
        // $cat_id=$product->category->pluck('category_id')->first();
        // $sub_cat=$product->subcategory->pluck('category_id')->first();
        
        // dd($product->toArray(),$cat_id,$sub_cat);
        // Group variations by type
        $out=[];
        // Initialize an empty array to store the transformed data
        $outputData = [];
        
        foreach ($product['variations'] as $item) {
            $variationType = $item['variation_type'];
            // $variationList = explode(',', $item['variation_list']);
        
            // Create a new array for each variation type
            $outputData[$variationType] = $item['variation_list'];
        }
        
        // Convert the output array to JSON for demonstration purposes
        $jsonOutput = json_encode($outputData);
        
        // Output the result
        //dd($jsonOutput,$outputData);
        $attribute_array=$outputData;
        $stocks=$product['all_stocks'];
        //dd($product['all_stocks']->toArray());
        
        $htmlContent = view('admin.product.test',compact(['attribute_array','stocks']))->render();
        
        //dd($product->toArray());
        return response()->json(['status'=>200,'product'=>$product,'variation'=>$htmlContent,'json_obj'=>$outputData]);
        
        dd($htmlContent);
        
        
        
    }
    public function adminProducts() {
        if(session()->has('user_id')){
            $products = Product::orderBy('id','DESC')->lazy();
            $categories = Category::lazy();
            return view('admin.product.products')->with(compact(['products','categories']));
        }else{
            return redirect()->route('Admin')->with('error','Login please.');
        }
    }

    public function appendProductSubCategory(Request $request) {
        $category_id = $request->category_id;
        $subCategories = Category::find($category_id)->subCategories;
        return view('admin.product.append-sub-category',compact(['subCategories']))
        ->render();
    }

    public function appendAttributeData(Request $request) {
        $attribute_array = json_decode($request->attribute_array,true);
        // dd($attribute_array);
        return view('admin.product.append-attribute-list',compact(['attribute_array']))->render();
    }
    public function appendAttributeData1(Request $request) {
        $product=Product::with(['category','variations','all_stocks','subcategory'])->find(13);
        // Initialize an empty array to store the transformed data
        $outputData = [];
        
        foreach ($product['variations'] as $item) {
            $variationType = $item['variation_type'];
            // $variationList = explode(',', $item['variation_list']);
        
            // Create a new array for each variation type
            $outputData[$variationType] = $item['variation_list'];
        }
        
        $attribute_array = json_decode($request->attribute_array,true);
        dd($outputData,$attribute_array);
        $attribute_array=$outputData;
        $stocks=$product['all_stocks'];
        
        $htmlContent = view('admin.product.test',compact(['attribute_array','stocks']))->render();
        
        
        
        
        
        // dd($attribute_array);
        return view('admin.product.append-attribute-list',compact(['attribute_array']))->render();
    }

    public function fetchProductPrice(Request $request) {
        $product_variation = $request->product_variation;
        return view('admin.product.fetch-product-price',compact(['product_variation']))->render();
    }

    public function storeProduct(Request $request) {
        dd($request->all());
        if(session()->has('user_id')) {
            $name = $request->name;
            $description = $request->description;
            $category_id = $request->category_id;
            $subcategory_id = $request->subcategory_id;
            $imageFile = $request->file('image');
            $imageFilePath = time().$imageFile->getClientOriginalName();
            $image = $imageFile->move('product/image',$imageFilePath);
            $galleryImages = $request->file('gallery_image');
            $productExists = Product::where(
                [
                    'name' => $name,
                    'category_id' => $category_id,
                    'subcategory_id' => $subcategory_id
                ]
            )->exists();
            if(!$productExists) {
                $product_id = Product::insertGetId(
                    [
                        'name' => $name,
                        'description' => $description,
                        'category_id' => $category_id,
                        'subcategory_id' => $subcategory_id,
                        'image' => $image
                    ]
                );
                if($request->product_variation == 'Single') {
                    Stock::updateOrCreate(
                        [
                            'product_id' => $product_id,
                            'variation_type' => 'Single'
                        ],
                        [
                            'product_id' => $product_id,
                            'variation_type' => 'Single',
                            'variation' => NULL,
                            'price' => $request->price,
                            'discount' => $request->discount_price,
                            'stock' => $request->stock
                        ]
                    );
                }
                if($request->product_variation == 'Variable') {
                    $variant_name_list = $request->variant_name_list;
                    $variant_name_list = $variant_name_list[0];
                    $variant_name_list = explode(',',$variant_name_list);
                    $variant_value_list = $request->variant_value_list;
                    $variant_value_list = $variant_value_list[0];
                    $variant_value_list = explode('|',$variant_value_list);
                    $variation = $request->variation;
                    $price = $request->price;
                    $discount = $request->discount;
                    $stock = $request->stock;
                    for ($i=0; $i < count($variation); $i++) { 
                        $variation[$i] = explode(',',$variation[$i]);
                        asort($variation[$i]);
                        $variation[$i] = implode(',',$variation[$i]);
                        Stock::insert(
                            [
                                'product_id' => $product_id,
                                'variation_type' => 'Variable',
                                'variation' => $variation[$i],
                                'price' => $price[$i],
                                'discount' => $discount[$i],
                                'stock' => $stock[$i]
                            ]
                        );
                    }
                    for ($j=0; $j < count($variant_name_list); $j++) { 
                        Variation::updateOrCreate(
                            [
                                'product_id' => $product_id,
                                'variation_type' => $variant_name_list[$j],
                                'variation_list' => $variant_value_list[$j]
                            ],
                            [
                                'product_id' => $product_id,
                                'variation_type' => $variant_name_list[$j],
                                'variation_list' => $variant_value_list[$j]
                            ]
                        );
                    }
                }
                for($i = 0; $i < count($galleryImages); $i++) {
                    $galleryImageName = $galleryImages[$i]->getClientOriginalName();
                    $gallery_image_path = $galleryImages[$i]->move('product/gallery',$galleryImageName);
                    $gallery_image_path = $gallery_image_path->getPathname();
                    Gallery::updateOrCreate(
                        [
                            'product_id' => $product_id,
                            'image' => $gallery_image_path
                        ],
                        [
                            'product_id' => $product_id,
                            'image' => $gallery_image_path
                        ]
                    );
                }
                return redirect()->back()
                ->with('success','Product Added');
            }else {
                return redirect()->back()
                ->with('error','Product Already Exists');
            }
        }else {
            return redirect()->route('Admin')->with('error','Login please.');
        }
    }
    
 public function changeProductStatus(Request $data){
    $id=$data->id;
    $status=$data->status;
    $Product=Product::where('id',$id)->update(
    [
    'status'=>$status
   
	]
);
   return redirect()->route('admin-products')->with('success','Status change successfully.');
}   
    
    
}
