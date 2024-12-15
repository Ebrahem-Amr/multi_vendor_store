@if ($errors->any())
    <div class="alert alert-danger ">
        <h3>Error Occured!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="form-group">
    <laple>Category name</laple>
    <input type="text" name="name" class="form-control" value="{{old('name',$category->name)}}">
</div>
<div class="form-group">
    <laple>Category parent</laple>
    <select name="parent_id" class="form-control form-select ">
        <option value="">Primary Category</option>
        @foreach ($categories as $parent)
        <option value="{{$parent->id}}" @selected(old('parent_id',$category->parent_id) === $parent->id)>{{$parent->name}}</option>
        @endforeach

    </select>
</div>
<div class="form-group">
    <laple>Description</laple>
    <textarea name="description" class="form-control">{{old('description',$category->description)}}</textarea>
</div>
<div class="form-group">
    <laple>Image</laple>
    <input type="file" name="image" class="form-control">
    @if ($category->image)
            <img src="{{ asset('storage/'. $category->image) }}" alt="" height="100">
    @endif

</div>
<div class="form-group">
    <laple>Status</laple>
    <div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="active" @checked(old('status',$category->status) ==='active')>
            <label class="form-check-label" for="flexRadioDefault1">
              active
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status"  value="archived"@checked(old('status',$category->status) ==='archived')>
            <label class="form-check-label" for="flexRadioDefault2">
              archived
            </label>
          </div>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Save</button>
</div>