@extends('admin.layout.master')


@section('content')

<div class="container">
    <form action="{{ route('admin-category-add') }}" method="POST">
        @csrf
        <div class="form-floating mt-5">
            <input type="text" class="form-control" id="input" name="name">
            <label for="input">Name</label>
          </div>

          <button class="btn btn-success mt-5" type="submit">Add category</button>

    </form>
</div>


@endsection
