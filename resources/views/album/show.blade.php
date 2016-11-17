@extends('layouts.lambda')

@section('innercnt')
    <div class="row">
        <div class="col-md-4">
            <h1 >{{ $album->name }}</h1>
        </div>
        <div class="col-md-4 col-md-push-2">
            <a href="{{ route("album.edit",$album) }}" class="btn btn-default">Edit</a>
        </div>

    </div>
    <div class="row">
        <p>{{ $album->description }}</p>
    </div>
    <div class="row">
        @include("partials.image.list",["images"=>$album->images()->get()])
    </div>


@endsection
