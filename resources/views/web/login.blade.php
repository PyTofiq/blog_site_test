@extends('web.layout.master')

@section('content')

<div class="container mt-5">

    <h4>Login</h4>

    <form action="{{ route('login-post') }}" method="POST">
    @csrf
          <div class="form-floating mt-5">
            <input type="email" class="form-control" id="admin-login-email" name="email" placeholder="name@example.com">
            <label for="admin-login-email">Email</label>
          </div>
          <div class="form-floating mt-5 mb-5">
            <input type="password" class="form-control" id="admin-login-password" name="password" >
            <label for="admin-login-password">Password</label>
          </div>
          @error('errors')
          <div class="alert alert-danger">{{ $message }}</div>
      @enderror

          <button class="btn btn-primary mt-5 mb-5" type="submit">Submit</button>

    </form>

</div>

@endsection
