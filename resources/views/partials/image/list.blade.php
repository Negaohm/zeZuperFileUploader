@foreach ($images as $key => $img)
  <img class="img-thumbnail" src="{{$img->url}}" alt="{{{$img->filename}}}"/>
@endforeach
