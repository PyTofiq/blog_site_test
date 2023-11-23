@extends('web.layout.master')

@section('content')
    <div class="container">

        <h2>{{ $user->name }}</h2>
        <p><strong>Email: </strong> {{ $user->email }}</p>
        <a href="{{ route('blog-add-page') }}" class="btn btn-outline-success">Add blog</a>
        <a href="{{ route('profile-edit-page') }}" class="btn btn-outline-primary">Edit profile</a>


        @include('web.components.blogs')




    </div>
@endsection
