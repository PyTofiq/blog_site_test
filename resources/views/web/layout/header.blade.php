<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>


    <div class="container mb-5 mt-5">
        <div class="navbar d-flex justify-content-between">
            <div class="nav-list d-flex">
                <h3>Blog website</h3>
                <ul>
                    <li><a href="{{ route('blogs') }}">Home</a></li>
                    @foreach ($categories as $category)
                        <li><a href="{{ route('blog-category', $category->id) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            @auth
            <div>
                <a href="{{ route('profile') }}">Profile</a>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
            @else
            <div>
                <a href="{{ route('login-page') }}">Log in</a>
                <a href="{{ route('register-page') }}">Register</a>
            </div>
            @endauth
        </div>
    </div>
