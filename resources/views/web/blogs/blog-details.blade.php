@extends('web.layout.master')

@section('content')

    <div class="container">

        <div class="blog-details">
            @if($isUser)
            <div class="mb-5">
                <a href="{{ route('blog-edit-page', $blog->id) }}" class="btn btn-success">Edit</a>
                <a href="{{ route('blog-delete', $blog->id) }}" class="btn btn-danger">Delete</a>
            </div>
            @endif

            {{-- {{ dd($blog) }} --}}
            @if($blog->image)
            <div class="blog-image mb-5">
                <img src="{{ asset('uploads/blogs/'.$blog->image) }}" alt="" width="100px" height="100px">
            </div>
            @endif

            <div class="blog-title">
                <h1>Title</h1>
                <p>{{ $blog->title }}</p>
            </div>
            <div class="blog-date mt-5 mb-5">
                <h5>Date</h5>
                <p>{{ \Carbon\Carbon::parse($blog->created_at)->format('d-m-Y') }}</p>
            </div>
            <div class="blog-author mt-5 mb-5">
                <h5>Author</h5>
                <p>{{ $blog->authors->name }}</p>
            </div>

            @if($blog->categories)
            <div class="blog-categories mt-5 mb-5">
                <h4>Categories</h4>
                @foreach ($blog->categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </div>
            @endif

            <div class="blog-text mt-5 mb-5">
                <h4>Description</h4>
                <p>{{ $blog->description }}</p>
            </div>
        </div>


        @if($blogs->count())

        <div class="related-blogs mb-5 mt-5">
            <h3>Related Blogs:</h3>
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


        @endif



    </div>






@endsection
