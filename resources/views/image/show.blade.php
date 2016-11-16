@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              @include('partials.image.show',$img)<!-- TODO $img does not exist-->
          </div>
      </div>
  </div>
@endsection
