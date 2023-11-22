@extends('web.layout.master')

@section('content')



<div class="container">
    <h1 class="mt-5 mb-5">Category: {{ $category->name }}</h1>

    <div class="blogs row mt-5">
        @foreach ($blogs as $blog)
        <div class="blog col-md-3">
            <div class="card">
              <img src="@if($blog->image) {{ asset('uploads/blogs/'.$blog->image) }} @else {{ asset('uploads/default.png') }} @endif" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title"><a href="{{ route('blog-details', $blog->id) }}">{{ $blog->title }}</a></h5>
                <p class="card-text">
                    @if($blog->categories)
                    @foreach($blog->categories as $cat)
                    <span>{{$cat->name}},</span>
                    @endforeach
                    @endif
                </p>
              </div>
            </div>
          </div>
        @endforeach
    </div>


</div>





@endsection
