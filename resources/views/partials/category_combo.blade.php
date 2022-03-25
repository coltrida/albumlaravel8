<select name="categories[]" class="form-select" aria-label="Default select example" multiple>
    @foreach($categories as $item)
        <option {{in_array($item->id, $selectedCategories) ? 'selected' : ''}} value="{{$item->id}}"> {{$item->category_name}} </option>
    @endforeach
</select>
