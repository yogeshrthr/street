function appendSubcategories(el) {
    if ($(el).val().length > 0) {
        $.ajax({
            url: 'append-product-sub-category',
            type: 'POST',
            data: {
                category_id: $(el).val()
            },
            success: function (appendSubcategoriesResponse) {
                $('#subcategory_id').html(appendSubcategoriesResponse);
            },
            error: function (appendSubcategoriesErrors) {
                console.log(appendSubcategoriesErrors);
            }
        });
    }
}
var attributeObj = {};

function fetchProductAttribute(product_id='') {
     var csrfToken = "{{ csrf_token() }}";
    $.ajax({
        url: 'append-attribute-data',
        type: 'POST',
        data: {
            _token: csrfToken,
            attribute_array: JSON.stringify(attributeObj),
            product_id:product_id,
        },
        success: function(attributeNameResponse) {
            $('#attributeNameList').html('');
            $('#attributeNameList').html(attributeNameResponse);
            $('#productAttribute').attr('required', false);
            $('#productAttribute').val('');
        },
        error: function(attributeNameError) {
            console.log(attributeNameError);
        }
    });
}

function fetchProductPrice(id) {
    if (id.value == 'Single') {
        $('#addProductBtn').attr('disabled', false);
        attributeObj = {};
        fetchProductAttribute();
    }
    $.ajax({
        url: 'fetch-product-price',
        type: 'POST',
        data: {
            product_variation: id.value
        },
        success: function(productPriceResponse) {
            $('#productPriceAndStock').html(productPriceResponse);
            fetchProductAttribute();
        },
        error: function(productPriceError) {
            console.log(productPriceError);
        }
    });
}
function disableSubmitBtn() {
    $('#addProductBtn').attr('disabled', true);
}
function enableProductStoreBtn() {
    $('#addProductBtn').attr('disabled', false);
}
function appendAttribute() {
    if ($('#productAttribute').val().length > 0) {

        var attributeValue = $('#productAttribute').val();
       
        //return false
        if(attributeObj=='')
        attributeObj = {};
        console.log(attributeValue,attributeObj)
        if (!(attributeValue in attributeObj)) {
            attributeObj[attributeValue] = {};
            //console.log(attributeObj);
            fetchProductAttribute();
        } else {
            $('#productAttribute').val('');
        }
    }
}
function deleteAttributeName(attribute,flag='') {
    console.log(attributeObj,typeof attributeObj)

    if(flag!=''){
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "admin/remove-variations", // Replace with your actual backend endpoint
            type: 'POST',
            data: {
                _token: csrfToken,
                attribute: attribute,
                flag:1,  //0 for attribute value 1- for delete attribute name
            },
            success: function(response) {
                // Handle success response here
                if(response.status==200){
                    if (attribute in attributeObj) {
                        delete attributeObj[attribute];
                    }
                    fetchProductAttribute();
                }else{

                }
            },
            error: function(error) {
                // Handle error here
                console.log(error);
            }
        });

    }else{
        if (attribute in attributeObj) {
            delete attributeObj[attribute];
        }
        fetchProductAttribute();
    }
    
}
function addAttributeValue(attribute, id,product_id='') {
    var attributeValueData = $('#' + id + '').val();
    if (JSON.stringify(attributeObj[attribute]) === '{}') {
        attributeObj[attribute] = attributeValueData;
    } else {
        attributeObj[attribute] = attributeObj[attribute] + ',' + attributeValueData;
    }
    $('#' + id + '').val('');
    fetchProductAttribute(product_id);
}
function removeAttributeValue(attribute_data, attribute, attribute_value,flag='') {
    if(flag!=''){
        console.log(flag)
        // return false
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "admin/remove-variations", // Replace with your actual backend endpoint
            type: 'POST',
            data: {
                _token: csrfToken,
                attribute_data: attribute_data,
                attribute: attribute,
                flag:0,  //0 for attribute value 1- for delete attribute name
            },
            success: function(response) {
                // Handle success response here
                if(response.status==200){
                    attribute_data = attribute_data.split("," + attribute_value + "").join("");
                    attribute_data = attribute_data.split(attribute_value).join("");
                    if (attribute_data.length == 0) {
                        attributeObj[attribute] = {};
                    } else {
                        attributeObj[attribute] = attribute_data;
                    }
                    fetchProductAttribute();
                }else{

                }
            },
            error: function(error) {
                // Handle error here
                console.log(error);
            }
        });
    }else{
        attribute_data = attribute_data.split("," + attribute_value + "").join("");
        attribute_data = attribute_data.split(attribute_value).join("");
        if (attribute_data.length == 0) {
            attributeObj[attribute] = {};
        } else {
            attributeObj[attribute] = attribute_data;
        }
        fetchProductAttribute();
    }

    
}