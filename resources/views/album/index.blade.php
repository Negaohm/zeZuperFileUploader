@extends('layouts.lambda')

@section('innercnt')
  @include('partials.album.list',['albums'=>$albums])
  <div class="btn btn-warning" >
      <a href="{{route('album.create')}}">Create one</a>
  </div>
@endsection
