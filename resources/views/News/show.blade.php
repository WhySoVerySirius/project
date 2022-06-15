@extends('template')


@section('content')

<div class="card text-center">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active" aria-current="true" href="#">Active</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <h5 class="card-title">{{$news->title}}</h5>
      <p class="card-text">Description: @if($news->description){{$news->description}}@endif</p>
      <p class="card-text">Category: @if($news->category){{$news->category->title}}@endif</p>
      <p class="card-text">Times seen: {{$news->view_count}}</p>
      <p class="card-text">Active: @if($news->active === 1) Yes @else No @endif</p>
      <a href="{{route('news.index')}}" class="btn btn-primary">Go back</a>
    </div>
  </div>

@endsection