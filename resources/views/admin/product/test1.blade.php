@php
   function normalizeVariation($variation)
    {
        $elements = explode(',', $variation);
        sort($elements);
        return implode(',', $elements);
    }
    function findVariation(array $variations, string $searchValue): ?array
    {
        $collection = collect($variations);
    
        $normalizedSearchValue = normalizeVariation($searchValue);
    
        $foundVariation= $collection->first(function ($variation) use ($normalizedSearchValue) {
            return normalizeVariation($variation['variation']) === $normalizedSearchValue;
        });
        return $foundVariation ?: [];
    }


@endphp
@if (count($attribute_array) > 0)
    @php
        $attribute_combination_array = [];
        $attribute_name_list = [];
        $attribute_value_list = [];
        //dd($attribute_array,$exist_attr);
    @endphp
    @foreach ($attribute_array as $attribute_name => $attribute_value)
        <div class="row g-2" id="attributeListValue">
            <div class="col-md-5 mb-0">
                <div class="form-group">
                    <label>{{ $attribute_name }}</label>
                    <input type="text" class="form-control attributeField" id="attribute{{ $attribute_name }}Value"
                        placeholder="Product Attribute Value">
                </div>
            </div>
            <div class="col-md-7 mb-0">
                <input onclick="addAttributeValue('{{ $attribute_name }}','attribute{{ $attribute_name }}Value')"
                    value="Add Attribute Value" type="button" class="btn btn-primary mt-4" name="add_product_attribute"
                    required />
                    @if (array_key_exists($attribute_name, $exist_attr))
                        <button type="button" onclick="deleteAttributeName('{{ $attribute_name }}','old')"
                            class="btn btn-sm btn-danger mt-4"><i class="fa fa-trash me-sm-1"></i></button>
                    @else
                        <button type="button" onclick="deleteAttributeName('{{ $attribute_name }}')"
                            class="btn btn-sm btn-danger mt-4"><i class="fa fa-trash me-sm-1"></i></button>
                    @endif
               
            </div>
        </div>
        <div class="row g-2">
            <div class="col mb-0">
                @if (isset($attribute_array[$attribute_name]) &&
                        $attribute_array[$attribute_name] != null &&
                        $attribute_array[$attribute_name] != '')
                    @php
                        $value = explode(',', $attribute_array[$attribute_name]);
                        array_push($attribute_combination_array, $value);
                        array_push($attribute_name_list,$attribute_name);
                        array_push($attribute_value_list,$attribute_array[$attribute_name]);
                    @endphp
                    @for ($i = 0; $i < count($value); $i++)
                        @if (isset($exist_attr[$attribute_name]) && in_array($value[$i], explode(',', $exist_attr[$attribute_name])))
                            
                            <span class="badge bg-primary text-white"><b>{{ $value[$i] }}</b><button type="button"
                                        onclick="removeAttributeValue('{{ $attribute_array[$attribute_name] }}','{{ $attribute_name }}','{{ $value[$i] }}','old')"
                                        class="btn btn-danger btn-xs p-0">
                                    <i class="fa fa-close m-1"></i>
                                </button>
                            </span>
                        @else
                         <?php //dd($attribute_array[$attribute_name],$attribute_name); ?>
                            <span class="badge bg-primary text-white"><b>{{ $value[$i] }}</b> <button type="button"
                                    onclick="removeAttributeValue('{{ $attribute_array[$attribute_name] }}','{{ $attribute_name }}','{{ $value[$i] }}')"
                                    class="btn btn-danger btn-xs p-0"><i class="fa fa-close m-1"></i></button> </span>
                        @endif

                        
                    @endfor
                @endif
            </div>
        </div>
        <?php 
        //dd($attribute_array,$attribute_combination_array,$attribute_name_list,$attribute_value_list);
        ?>
    @endforeach
    {{-- {{ var_dump($attribute_combination_array) }} --}}
    @php
        $result = [];
        $attribute_combination_array = array_values($attribute_combination_array);
        $sizeIn = sizeof($attribute_combination_array);
        $size = $sizeIn > 0 ? 1 : 0;
        foreach ($attribute_combination_array as $array) {
            $size = $size * sizeof($array);
        }
        for ($i = 0; $i < $size; $i++) {
            $result[$i] = [];
            for ($j = 0; $j < $sizeIn; $j++) {
                array_push($result[$i], current($attribute_combination_array[$j]));
            }
            for ($j = $sizeIn - 1; $j >= 0; $j--) {
                if (next($attribute_combination_array[$j])) {
                    break;
                } elseif (isset($attribute_combination_array[$j])) {
                    reset($attribute_combination_array[$j]);
                }
            }
        }
    @endphp
    @for ($i = 0; $i < count($result); $i++)
        <div class="row g-2">
            <input type="hidden" name="variant_name_list[]" value="{{implode(',',$attribute_name_list)}}">
            <input type="hidden" name="variant_value_list[]" value="{{implode('|',$attribute_value_list)}}">
            <input type="hidden" name="variation[]" value="{{ implode(',', $result[$i]) }}">
            <div class="col mb-0">
                <label>Attributes</label>
                <p><span class="badge bg-primary text-white">{{ implode(',', $result[$i]) }}</span></p>
                <?php //dd(findVariation($stocks->toArray(), implode(',', $result[$i]))  );
                    $product_data=findVariation($stocks->toArray(), implode(',', $result[$i])) ;
                ?>
            </div>
            <div class="col mb-0">
                <div class="form-group">
                    <label>Product Price</label>
                    <input onclick="enableProductStoreBtn()" value="{{$product_data['price']?? ''}}" type="text" name="price[]" class="form-control" placeholder="Product Price" required>
                </div>
            </div>
            <div class="col mb-0">
                <div class="form-group">
                    <label>Discount Price</label>
                    <input type="text" name="discount[]" value="{{$product_data['discount']?? ''}}" class="form-control" placeholder="Discount Price"
                    required>
                </div>
            </div>
            <div class="col mb-0">
                <div class="form-group">
                    <label>Product Stock</label>
                    <input type="text" name="stock[]"  value="{{$product_data['stock']?? ''}}" class="form-control" placeholder="Stock" required>
                </div>
            </div>
            <div class="col mb-0">
                <div class="form-group">
                    <label>Variation Image</label>
                    <input type="file" name="variation_img[<?php echo $i;?>]" accept="image/*" class="form-control" placeholder="" >
                </div>
            </div>
        </div>
    @endfor
@endif