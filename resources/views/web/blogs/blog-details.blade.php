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
            <div class="blog-image mb-5">
                <img src="{{ $blog->coverImage() }}" alt="" width="100px" height="100px">
            </div>

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
            @include('web.components.blogs')

        </div>


        @endif



    </div>






@endsection
