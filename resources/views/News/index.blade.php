@extends('template')


@section('content')
<a href="{{route('news.create')}}" class='btn btn-success'>Create news</a>
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">Category</th>
        <th scope="col">Active</th>
        <th scope='col'>Image</th>
        <th scope='col'>Actions</th>
      </tr>
    </thead>
    <tbody>
        @foreach($news as $new)
        {{-- <p>{{$new}}</p> --}}
        <tr>
            <th scope="row">{{$new->id}}</th>
            <td>{{$new->title}}</td>
            <td>@if($new->description){{$new->description}}@endif</td>
            <td>@if($new->category){{$new->category->title}}@endif  {{$new->created_at}}</td>
            <td>{{$new->active}}</td>
            <td>@if($new->image)<img src="{{asset($new->image)}}" alt="" style="height: 60px; width: 80px">@endif</td>
            <td>
                <a href="{{route('news.edit', $new)}}"  class='btn btn-info'>Edit</a>
                <form action="{{route('news.destroy', $new)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete" class='btn btn-danger'>
                </form>
                <a href="{{route('news.show', $new)}}" class='btn btn-primary'>Inspect</a>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>

  {{$news->links()}};


@endsection