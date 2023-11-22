@extends('web.layout.master')


@section('content')

<div class="container">
    <form action="{{ route('blog-add-post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-floating mt-5 mb-5">
            <input type="text" class="form-control" id="input" name="name">
            <label for="input">Title</label>
          </div>
          <div class="form-floating mt-5 mb-5">
            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="description"></textarea>
            <label for="floatingTextarea">Description</label>
          </div>
          <div class="btn-group mt-5 mb-5" role="group" aria-label="Basic checkbox toggle button group">
            @foreach ($categories as $category)
            <input type="checkbox" class="btn-check" id="btncheck-category-{{ $category->id }}" name="category[]" value="{{ $category->id }}">
            <label class="btn btn-outline-primary" for="btncheck-category-{{ $category->id }}">{{ $category->name }}</label>
            @endforeach
          </div>
          <div>
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Default file input example</label>
            <input class="form-control" type="file" id="formFile" name="image">
          </div>

          <button class="btn btn-success mt-5" type="submit">Add Blog</button>

    </form>
</div>


@endsection
