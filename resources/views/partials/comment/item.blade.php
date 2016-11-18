<li class="media">
  <div class="media-left">
      <a href="{!! route("image.comment.show",["comment"=>$comment,"image"=>$comment->image]) !!}">
        <img style="width:15px;height:15px;" class="media-object" src="{!! url('/image/1/thumbnail') !!}" alt="avatar">
      </a>
  </div>
  <div class="media-body">
    <h4 class="media-heading">{{ $comment->user->name }}</h4>
    <p>
      {{ $comment->text }}
    </p>
    <button class="btn btn-default" role="button" data-toggle="collapse" href="#reply-{{ $comment->id }}" aria-expanded="false" aria-controls="collapseExample">reply</button>
    <div class="collapse" id="reply-{{ $comment->id }}">
      <div class="well">
        @include("partials.comment.form",compact("comment"))
      </div>
    </div>
    @if(env("EDIT_COMMENT",false) && \Auth::check() && $img->user->id == \Auth::user()->id)
      <div class="btn-group btn-group-sm" role="group" aria-label="...">
        <a href="{{ route("comment.edit",$comment) }}" type="button" class="btn btn-info">Edit</a>
      </div>
    @endif
      @each('partials.comment.item', $comment->children(), 'comment')
  </div>
</li>
