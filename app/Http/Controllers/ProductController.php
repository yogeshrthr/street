<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Stock;
use App\Models\Variation;
use DB;
use Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function edit_products(Request $request){
        $product=Product::with(['variations','all_stocks'])->find($request->product_id); 
        // dd(count($product->variations)==count(explode(',',$request->variant_name_list[0])));
        // dd($request->all());

        if(session()->has('user_id')) {
            $product=Product::with(['variations','all_stocks'])->find($request->product_id);            
            // $product->name=$request->name;
            // $product->category_id=$request->category_id;
            // $product->subcategory_id=$request->subcategory_id;
            // $product->description=$request->description;
            // $product->save();

            // checking here while edit added any new variation or not
            if(count($product->variations)==count(explode(',',$request->variant_name_list[0]))){
                $variation=explode(',',$request->variant_name_list[0]);                            
                foreach($variation as $key=>$item){
                    $vr=Variation::where(['product_id'=>$product->id,'variation_type'=>$item])->first();
                    if ($vr) {
                        $vr->variation_list =$variant_value_list[$key] ;
                        $vr->save();
                    }
                    // dd($vr->toArray());
                }
            }else{
               
                $existingVariationTypes = Variation::where('product_id', $product->id)->pluck('variation_type')->toArray();
                foreach ($variation as $key => $variantValue) {
                    $variationType = $request->variant_value_list[$key];
                    
                    Variation::updateOrCreate(
                        ['product_id' => $product->id, 'variation_type' => $variationType],
                        ['variation_list' => $variantValue]
                    );

                    // Remove the processed variation type from the list of existing variation types
                    $index = array_search($variationType, $existingVariationTypes);
                    if ($index !== false) {
                        unset($existingVariationTypes[$index]);
                    }
                }

                // Delete the remaining variations that were not updated or created
                Variation::where('product_id', $product->id)
                    ->whereIn('variation_type', $existingVariationTypes)
                    ->delete();




                // $variation=explode(',',$request->variant_name_list[0]);                            
                // foreach($variation as $key=>$item){
                //     $vr=Variation::where(['product_id'=>$product->id,'variation_type'=>$item])->first();
                //     if ($vr) {
                //         $vr->variation_list =$variant_value_list[$key] ;
                //         $vr->save();
                //     }
                //     // dd($vr->toArray());
                // }
            }
            if(isset($stock_flag))
            // update stocks value
            foreach($request->variation as $key=>$variation){
                $stocks = Stock::where('product_id', 13)
                ->where('variation_type', 'Variable')
                ->where(function ($query) use ($variation) {
                    // Check for the original variation
                    $query->where('variation', 'LIKE', '%' . $variation . '%');

                    // Check for the reversed variation
                    $reversedVariation = implode(',', array_reverse(explode(',', $variation)));
                    $query->orWhere('variation', 'LIKE', '%' . $reversedVariation . '%');
                })
                ->firstOrNew();

                // If the record was not found, set the variation column and other attributes
                if (!$stocks->exists) {
                $stocks->product_id = 13; // Set the product_id
                $stocks->variation_type = 'Variable';
                $stocks->variation = $variation;
                // Continue with handling the image
                if (isset($request->variation_img) && count($request->variation_img) && isset($request->variation_img[$key])) {
                    
                    $oldImagePath = $stocks->variation_img;
                    if ($oldImagePath && File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }

                    $imageFile = $request->variation_img[$key];
                    $imageFilePath = time() . $imageFile->getClientOriginalName();
                    $destinationPath = 'product/image/variation_images';

                    // Check if the destination directory exists, and create it if not
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory($destinationPath, $mode = 0777, true, true);
                    }

                    $image = $imageFile->move($destinationPath, $imageFilePath);
                    // Update the stock model with the new image path
                    $stocks->variation_img = $image->getPathname();
                }

                // Update other attributes
                $stocks->discount = $request->discount[$key];
                $stocks->price = $request->price[$key];
                $stocks->stock = $request->stock[$key];
                // Save the stock model
                $stocks->save();
                }              ;
            }
            
            dd($request->all());
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
        $exist_attr=$attribute_array;
        $htmlContent = view('admin.product.test1',compact(['attribute_array','stocks','exist_attr']))->render();
        
        if($product->all_stocks[0]->variation_type=='Variable')
            $produt_price='<div class="col mb-0">
                        <div class="form-group">
                            <label>Product Variation</label>
                            <select onchange="fetchProductPrice(this)" name="product_variation" class="form-control" >
                                <option value="Single">Single</option>
                                <option value="Variable" selected="">Variable</option>
                            </select>
                        </div>
                    </div>
                    <div class="col mb-0">
                        <div class="form-group">
                            <label>Product Attribute</label>
                            <input oninput="disableSubmitBtn()" type="text" class="form-control" id="productAttribute" placeholder="Product Attribute" >
                        </div>
                    </div>
                    <div class="col mb-0">
                        <input onclick="appendAttribute()" value="Add Attribute" type="button" class="btn btn-primary mt-4" name="add_product_attribute" required="">
                    </div>';

        else
            $produt_price='<div class="col mb-0">
                            <div class="form-group">
                                <label>Product Type</label>
                                <select onchange="fetchProductPrice(this)" name="product_variation" class="form-control" required="">
                                    <option value="Single" selected="">Single</option>
                                    <option value="Variable">Variable</option>
                                </select>
                            </div>
                        </div>
                        <div class="col mb-0">
                            <div class="form-group">
                                <label>Product Price</label>
                                <input type="number" class="form-control" name="price" placeholder="Product Price" required="">
                            </div>
                        </div>
                        <div class="col mb-0">
                            <div class="form-group">
                                <label>Discount Price</label>
                                <input type="number" class="form-control" name="discount_price" placeholder="Discount Price" required="">
                            </div>
                        </div>
                        <div class="col mb-0">
                            <div class="form-group">
                                <label>Product Stock</label>
                                <input type="number" class="form-control" name="stock" placeholder="Product Stock" required="">
                            </div>
                        </div>';

        //dd($product->all_stocks[0]->variation_type=='Variable');
        //dd($product->toArray());
        return response()->json(['status'=>200,'product'=>$product,'variation'=>$htmlContent,'json_obj'=>$outputData,'product_price'=>$produt_price]);
        
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
        
        $result = [];   
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
        //dd(array_keys($outputData + $attribute_array) );
        foreach (array_keys($outputData + $attribute_array) as $key) {
            if((isset($attribute_array[$key]) && !empty($attribute_array[$key])) &&  (isset($outputData[$key]) && !empty(($outputData[$key])) )){
                $value1 = isset($outputData[$key]) ? trim($outputData[$key], ',') : '';
                $value2 = isset($attribute_array[$key]) ? trim($attribute_array[$key], ',') : '';        
                $result[$key] = implode(',', array_unique(array_merge(explode(',', $value1), explode(',', $value2))));            
                // Remove both leading and trailing commas
                $result[$key] = trim($result[$key], ',');
            }else{
                $result[$key]=$attribute_array[$key];
            }
            
        }
        
        
        // dd($outputData,$attribute_array,$result );
        $exist_attr=$outputData;
        $attribute_array=$result;
        $stocks=$product['all_stocks'];       
        return view('admin.product.test1',compact(['attribute_array','stocks','exist_attr']))->render();







        // $attribute_array = json_decode($request->attribute_array,true);
        // // dd($attribute_array);
        // return view('admin.product.append-attribute-list',compact(['attribute_array']))->render();
    }
    // public function appendAttributeData1(Request $request) {
    //     $product=Product::with(['category','variations','all_stocks','subcategory'])->find(13);
    //     // Initialize an empty array to store the transformed data
    //     $outputData = [];
        
    //     foreach ($product['variations'] as $item) {
    //         $variationType = $item['variation_type'];
    //         // $variationList = explode(',', $item['variation_list']);
        
    //         // Create a new array for each variation type
    //         $outputData[$variationType] = $item['variation_list'];
    //     }
        
    //     $attribute_array = json_decode($request->attribute_array,true);
    //     dd($outputData,$attribute_array);
    //     $attribute_array=$outputData;
    //     $stocks=$product['all_stocks'];
        
    //     $htmlContent = view('admin.product.test',compact(['attribute_array','stocks']))->render();
        
        
        
        
        
    //     // dd($attribute_array);
    //     return view('admin.product.append-attribute-list',compact(['attribute_array']))->render();
    // }

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
        $Product=Product::where('id',$id)->update([
                'status'=>$status
                ]
            );
        return redirect()->route('admin-products')->with('success','Status change successfully.');
    }  
    public function remove_product_variation(Request $request) {
        dd($request->all());
    }
    
    
}
