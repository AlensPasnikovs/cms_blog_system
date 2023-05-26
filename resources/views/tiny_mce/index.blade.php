@extends('layouts.app')

@section('headScripts')
<script src="https://cdn.tiny.cloud/1/j99m3hzybcfd4631gg5p9d9mb5csjop9c73qkd99t3ixujt7/tinymce/6/tinymce.min.js"
   referrerpolicy="origin"></script>
@endsection

@section('content')

@if (session()->has('time_taken'))
<div class="row mx-sm-1 mx-lg-3 mx-xl-5 mx-0">
   <div class="">
      <div class="alert alert-info" style="font-size: 20px;">
         Time taken: <strong>{{ is_numeric(session('time_taken')) ? number_format(floatval(session('time_taken')), 2) :
            session('time_taken') }}</strong> seconds
      </div>
   </div>
</div>
@endif


@if (Auth::check())
<div class="row mx-sm-1 mx-lg-3 mx-xl-5 mx-0">
   <div class="">
      <button class="btn btn-success float-end " data-bs-toggle="modal"
         data-bs-target="#create_post_modal">{{__('messages.new_post');}}</button>
   </div>
</div>
@endif

@if ($errors->any())
<div class="row mx-sm-1 mx-lg-3 mx-xl-5 mx-0 mt-2">
   <div class="">
      <div class="alert alert-danger mb-0">
         <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
   </div>
</div>
@endif
@if ($message = Session::get('success'))
<div class="row mx-sm-1 mx-lg-3 mx-xl-5 mx-0">
   <div class="">
      <div class="alert alert-success alert-block mb-0 mt-2">
         <strong>{{ $message }}</strong>
      </div>
   </div>
</div>
@endif


<div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 row-cols-sm-1 g-4 mx-sm-1 mx-lg-3 mx-xl-5 mx-0 mt-0"
   id="post_container">

   @include('tiny_mce.partials.posts')
</div>
@include('tiny_mce.create_post_modal')
@include('tiny_mce.edit_post_modal')

@endsection

@section('scripts')
<script>
   var translations = @json(trans("js_translations"));
</script>
<script type="module" src="{{ asset('js/tinymce.js') }}"></script>
@endsection