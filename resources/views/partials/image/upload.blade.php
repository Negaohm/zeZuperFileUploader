
<form class="" action="{{ route('image.upload') }}" method="post" enctype="multipart/form-data">
  <h2>Upload an Image</h2>
  <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
  <div class="input-group">
    <span class="input-group-addon">File</span>
    <input class="form-control" type="file" name="file" value="" placeholder="" multiple accept='image/*'>
  </div>
  {{ csrf_field() }}
  <select class="form-control" name="album">

    @foreach($albums as $al)
      <option value="{{$al->id}}">{{$al->name}}</option>
    @endforeach
  </select>
  <input class="btn btn-primary" type="submit" name="fileUpload" value="Upload">
</form>
