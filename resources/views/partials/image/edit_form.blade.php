<form class="" action="{{ route('image.update') }}" method="post">
  <h2>Edit Image <small>{{{$img->filename}}}</small></h2>
  <img class="img-thumbnail" src="{{$img->url}}" alt="{{{$img->filename}}}"/>
  <select class="form-control" name="album">
    {{ csrf_field() }}
    @foreach($albums as $al)
      <option value="{{$al->id}}">{{$al->name}}</option>
    @endforeach
  </select>
  <input class="btn btn-primary" type="submit" name="edit_image" value="Update">
</form>
