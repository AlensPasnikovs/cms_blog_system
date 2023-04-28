@extends('layouts.app')

@section('content')
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <h3 class="mt-2">{{ $post->title }}</h3>
         </div>
         <div class="card-body post-content hyphens">
            {!! $post->content !!}
         </div>
      </div>
   </div>
</div>
</div>
@endsection

@section('scripts')

<script>
   function resizeIframes() {
      var iframes = document.querySelectorAll('.card-body iframe');
      iframes.forEach(function(iframe) {
      var width = iframe.offsetWidth;
      var height = width * 9 / 16;
      iframe.style.height = height + 'px';
      });
   }

window.addEventListener('resize', resizeIframes);
resizeIframes();
</script>


@endsection