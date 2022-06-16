@extends('template')

@section('content')

<form action="{{route('news.update', $news)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Title</label>
      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name='title' value={{$news->title}}>
    </div>
    <div class="mb-3">
        <textarea name="description" id="" cols="30" rows="10" placeholder="Description">@if($news->description){{$news->description}}@endif
        </textarea>
    </div>
    <div class="mb-3">
        <label for="category">Category</label>
        <select name="category_id" id="">
            <option value="">-------//-------</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}" @if($news->category) @if($category->id === $news->category->id)selected @endif @endif>{{$category->title}}</option>
            @endforeach
        </select>
    </div>
    @if($news->image)
    <img src="{{asset($news->image)}}" alt="" style="height: 200px; width: 400px">
    <label for="image">Would you like to change the image?</label>
    @else
    <label for="image">Would you like to add an image?</label>
    @endif
    <input type="file" name='image'>
    <div class="mb-3 form-check">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="active" id="flexRadioDefault1" value='1' @if($news->active === 1)checked @endif>
            <label class="form-check-label" for="flexRadioDefault1">
              Active
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="active" id="flexRadioDefault2" value='0'@if($news->active !== 1)checked @endif>
            <label class="form-check-label" for="flexRadioDefault2">
              Inactive
            </label>
          </div>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
@endsection