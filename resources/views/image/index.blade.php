@extends('layouts.lambda')

@section('innercnt')
  @include('partials.image.list',['images'=>$images])
  <div class="btn btn-warning" >
      <a href="{{route('image.create')}}">Add one</a>
  </div>
@endsection
