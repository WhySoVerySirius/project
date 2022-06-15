@extends('template')

@section('content')
<form action="{{route('news.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Title</label>
      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name='title'>
    </div>
    <div class="mb-3">
        <textarea name="description" id="" cols="30" rows="10" placeholder="Description"></textarea>
    </div>
    <div class="mb-3">
        <label for="category">Category</label>
        <select name="category_id" id="">
            <option value="">-------//-------</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->title}}</option>
            @endforeach
        </select>
    </div>
    <label for="image">Add an image</label>
    <input type="file" name="image" id="">
    <div class="mb-3 form-check">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="active" id="flexRadioDefault1" value='1' checked>
            <label class="form-check-label" for="flexRadioDefault1">
              Active
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="active" id="flexRadioDefault2" value='0'>
            <label class="form-check-label" for="flexRadioDefault2">
              Inactive
            </label>
          </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection