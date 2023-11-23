@extends('admin.layout.master')


@section('content')

<div class="container">

    @if ($errors->any())
    <div class="alert alert-danger mb-5 mt-5">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



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
