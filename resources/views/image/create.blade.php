@extends('layouts.lambda')

@section('innercnt')
  @include('partials.file.upload',['album'=>$album])
@endsection
