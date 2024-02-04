<option value="">Select</option>
@foreach($subCategories as $subCategory) 
    <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
@endforeach