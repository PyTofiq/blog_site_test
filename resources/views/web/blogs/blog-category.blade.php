@extends('web.layout.master')

@section('content')



<div class="container">
    <h1 class="mt-5 mb-5">Category: {{ $category->name }}</h1>

    @include('web.components.blogs')


</div>





@endsection
