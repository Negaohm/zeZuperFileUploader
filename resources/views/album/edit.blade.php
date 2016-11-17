@extends('layouts.lambda')

@section('innercnt')
  @include('partials.album.edit_form',['album'=>$al])
@endsection
