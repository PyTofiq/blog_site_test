@extends('admin.layout.master')



@section('content')
<div class="container">

    <h2>Blogs table</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Categories</th>
                <th scope="col">Author</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
            </tr>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $blog->title }}</td>
                        <td>
                            @if($blog->categories)
                            @foreach($blog->categories as $cat)
                            {{ $cat->name }},
                            @endforeach
                            @endif
                        </td>
                        <td>{{ $blog->authors->name }}</td>
                        <td>          <img src="@if($blog->image) {{ asset('uploads/blogs/'.$blog->image) }} @else {{ asset('uploads/default.png') }} @endif" alt="" width="100px" height="100px"></td>
                        <td>
                            <a href="{{ route('admin-blog-edit-page', $blog->id) }}" class="btn btn-outline-success">Edit</a>
                            <a href="{{ route('admin-blog-delete', $blog->id) }}" class="btn btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </thead>
    </table>
</div>


@endsection


@if(session('success'))
<script>
    alert('{{ session("success") }}')
</script>

@endif
