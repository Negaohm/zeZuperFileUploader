@if(isset($comment))
    <form class="" action="{{ route('image.comment.store',$comment->image) }}" method="post">
    <input type="hidden" name="parent" value="{{ $comment->id }}">
@else
        <form class="" action="{{ route('image.comment.store',$image) }}" method="post">
@endif
            <input class="btn btn-primary" type="submit" name="update_album" value="Comment">
            <textarea class="form-control" name="text" placeholder="Comment"></textarea>
{{ csrf_field() }}
</form>
