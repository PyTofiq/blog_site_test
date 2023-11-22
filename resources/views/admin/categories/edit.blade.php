@extends('admin.layout.master')


@section('content')

<div class="container">
    <form action="{{ route('admin-category-edit', $old->id) }}" method="POST">
        @csrf
        <div class="form-floating mt-5">
            <input type="text" class="form-control" id="input" name="name" value="{{ $old->name }}">
            <label for="input">Name</label>
          </div>

          <button class="btn btn-success mt-5" type="submit">Edit category</button>

    </form>
</div>


@endsection
