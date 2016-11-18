<li class="media">
  <div class="media-left">
      <a href="{!! $comment->url() !!}">
        <img style="width:15px;height:15px;" class="media-object" src="{!! url('/image/1/thumbnail') !!}" alt="avatar">
      </a>
    </div>
  </div>
  <div class="media-body">
    <h4 class="media-heading"{{ $comment->user()->name }}</h4>
    <p>
      {{ $comment->text }}
    </p>
    @if(\Auth::check() && $img->user->id == \Auth::user()->id)
      <div class="btn-group btn-group-sm" role="group" aria-label="...">
        <a href="{{ route("comment.edit",$comment) }}" type="button" class="btn btn-info">Edit</a>
      </div>
    @endif
      @each('partials.comment.item', $comment->children(), 'comment')
  </div>
</li>
