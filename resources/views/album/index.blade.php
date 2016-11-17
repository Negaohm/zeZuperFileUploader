@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              @include('partials.album.list') <!-- TODO  give $album and do a forech on partial.album.list-->
              <div class="btn btn-warning" >
                  <a href="{{route('album.create')}}">Create one</a>
              </div>
          </div>
      </div>
  </div>
@endsection
