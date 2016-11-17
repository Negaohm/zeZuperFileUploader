<div class="col-md-4">
  <a href="{!! $img->url !!}" class="thumbnail" style="margin-bottom:2px"><img class="img-responsive img-thumbnail" src="{!! $img->thumbnail_url !!}" alt="{{{$img->original_filename}}}"/></a>
  <div class="caption">
    <p class="small text-center center-block hidden-sm" style="text-overflow:ellipsis;">uploaded {{ $img->created_at->diffForHumans() }} </p>
  </div>
</div>
