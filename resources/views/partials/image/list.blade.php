@foreach ($images as $key => $img)
  <a href="{!! $img->url !!}"><img class="img-thumbnail" src="{!! $img->thumbnail_url !!}" alt="{{$img->filename}}"/></a>
@endforeach
