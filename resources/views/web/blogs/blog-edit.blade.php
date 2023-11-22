@extends('web.layout.master')


@section('content')
{{-- {{ dd($old->categories) }} --}}

<div class="container">
    <form action="{{ route('blog-edit-post', $old->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-floating mt-5 mb-5">
            <input type="text" class="form-control" id="input" name="name" value="{{ $old->title }}">
            <label for="input">Title</label>
          </div>
          <div class="form-floating mt-5 mb-5">
            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="description">{{ $old->description }}</textarea>
            <label for="floatingTextarea">Description</label>
          </div>
          <div class="btn-group mt-5 mb-5" role="group" aria-label="Basic checkbox toggle button group">
            @foreach ($categories as $category)
            @php $isChecked = in_array($category->id, $old->categories->pluck('id')->toArray()); @endphp
            <input type="checkbox" class="btn-check" id="btncheck-category-{{ $category->id }}" name="category[]" {{ $isChecked ? 'checked' : '' }} value="{{ $category->id }}">
            <label class="btn btn-outline-primary" for="btncheck-category-{{ $category->id }}">{{ $category->name }}</label>
            @endforeach
          </div>
          <div>
          <img src="@if($old->image) {{ asset('uploads/blogs/'.$old->image) }} @else {{ asset('uploads/default.png') }} @endif" alt="" width="100px" height="100px" class="mt-5 mb-5">

          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Default file input example</label>
            <input class="form-control" type="file" id="formFile" name="image">
          </div>

          <button class="btn btn-success mt-5" type="submit">Edit Blog</button>

    </form>
</div>


@endsection
