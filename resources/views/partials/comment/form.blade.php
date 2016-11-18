@if(isset($comment))
<form class="" action="{!! route('comment.update',$comment) !!}" method="post">
  {{ method_field('PATCH') }}
  <h2>Edit Comment <small>{{ $comment->id }}</small></h2>
  <input type="hidden" name="id" value="{{ $comment->id }}"
  <textarea class="form-control" name="text" placeholder="album desc">{{ $comment->text }}</textarea>
  <input class="btn btn-primary" type="submit" name="update_album" value="Update">
@else
<form class="" action="{{ route('comment.store') }}" method="post">
<h2>Comment</h2>
<textarea class="form-control" name="text" placeholder="album desc"></textarea>
<input class="btn btn-primary" type="submit" name="update_album" value="Update">
@endif
{{ csrf_field() }}
</form>
