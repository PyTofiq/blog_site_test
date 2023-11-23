@extends('admin.layout.master')



@section('content')
<div class="container">

    

    <h2>Category table</h2>
    <a class="btn btn-success mb-5" href="{{ route('admin-category-add-page') }}">Create new category</a>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Count</th>
                <th scope="col">Actions</th>
            </tr>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $category->name }}</td>
                        <td></td>
                        <td>
                            <a href="{{ route('admin-category-edit-page', $category->id) }}" class="btn btn-outline-success">Edit</a>
                            <a href="{{ route('admin-category-delete', $category->id) }}" class="btn btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </thead>
    </table>
</div>


@endsection
