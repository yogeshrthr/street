@if ($product_variation == 'Single')
<?php if (session()->has('product_variation')) {
            $product_variation = session('product_variation');
        } else {
            $product_variation = []; 
        } 
?>
    <div class="col mb-0">
        <div class="form-group">
            <label>Product Type</label>
            <select onchange="fetchProductPrice(this)" name="product_variation"   class="form-control" required>
                <option value="Single" selected>Single</option>
                <option value="Variable">Variable</option>
            </select>
        </div>
    </div>
    <div class="col mb-0">
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" class="form-control" name="price" value="{{isset($product_variation['price'])?$product_variation['price']:''}}"  placeholder="Product Price" required>
        </div>
    </div>
    <div class="col mb-0">
        <div class="form-group">
            <label>Discount Price</label>
            <input type="number" class="form-control" name="discount_price"  value="{{isset($product_variation['discount'])?$product_variation['discount']:''}}" placeholder="Discount Price" required>
        </div>
    </div>
    <div class="col mb-0">
        <div class="form-group">
            <label>Product Stock</label>
            <input type="number" class="form-control" value="{{isset($product_variation['stock'])?$product_variation['stock']:''}}" name="stock" placeholder="Product Stock" required>
        </div>
    </div>
@endif
@if ($product_variation == 'Variable')

    <div class="col mb-0">
        <div class="form-group">
            <label>Product Variation</label>
            <select onchange="fetchProductPrice(this)" name="product_variation" class="form-control" required>
                <option value="Single">Single</option>
                <option value="Variable" selected>Variable</option>
            </select>
        </div>
    </div>
    <div class="col mb-0">
        <div class="form-group">
            <label>Product Attribute</label>
            <input oninput="disableSubmitBtn()" type="text" class="form-control" id="productAttribute" placeholder="Product Attribute" required>
        </div>
    </div>
    <div class="col mb-0">
        <input onclick="appendAttribute()" value="Add Attribute" type="button" class="btn btn-primary mt-4" name="add_product_attribute" required/>
    </div>
@endif