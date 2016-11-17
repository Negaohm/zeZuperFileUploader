<div class="panel panel-default">
    <div class="panel-heading">
      <span class="popOver" data-toggle="popover" data-trigger="focus" title="Description" data-content="{{{$al->description}}}">
        {{{$al->name}}}
      </span>
    </div>
    <div class="panel-body">
        @include('partials.image.list',['images'=>$al->images()])
    </div>
</div>
