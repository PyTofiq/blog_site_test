@extends('web.layout.master')

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


        <form action="{{ route('profile-edit') }}" method="POST">
            @csrf
            <div class="form-floating mt-5 mb-5">
                <input type="text" class="form-control" id="name" name="name" value="{{ $old->name }}">
                <label for="name">Name</label>

                <div class="form-floating mt-5 mb-5">
                    <input type="email" class="form-control" id="email" name="email" value="{{ $old->email }}">
                    <label for="email">Email</label>
                </div>

                <div class="form-floating mt-5 mb-5">
                    <input type="password" class="form-control" id="password" name="password">
                    <label for="password">password</label>
                </div>


                <button class="btn btn-success">Update Profile</button>


            </div>



        </form>
    </div>
@endsection
