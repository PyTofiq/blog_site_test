<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

<div class="container mb-5">
    <div class="navbar d-flex justify-content-between">
        <div class="nav-list d-flex">
            <h3>Admin panel</h3>
            <ul>
                <li><a href="{{ route('admin-users') }}">Users</a></li>
                <li><a href="{{ route('admin-blogs') }}">Blogs</a></li>
                <li><a href="{{ route('admin-categories') }}">Categories</a></li>
            </ul>
        </div>
        <a href="{{ route('admin-logout') }}">Log out</a>
    </div>
</div>


