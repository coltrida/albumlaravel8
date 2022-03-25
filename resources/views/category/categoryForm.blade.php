@include('partials.inputError')
<form action="{{$category->id ? route('categories.update', $category->id) : route('categories.store')}}" method="post">
    @csrf
    @if($category->id)
        @method('PATCH')
    @endif
    <div class="mb-3">
        <label for="category_name" class="form-label">Name</label>
        <input type="text" class="form-control"
               value="{{$category->id ? $category->category_name : ''}}"
               id="category_name"
               name="category_name"
               aria-describedby="emailHelp">
    </div>
    <button type="submit" class="btn btn-primary"> {{$category->id ? 'Modifica': 'salva'}}</button>
</form>
