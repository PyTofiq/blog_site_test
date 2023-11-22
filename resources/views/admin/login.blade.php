<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>

    <div class="container mt-5">

        <h4>Login</h4>

        <form action="{{ route('admin-login-post') }}" method="POST">
        @csrf
              <div class="form-floating mt-5">
                <input type="email" class="form-control" id="admin-login-email" name="email" placeholder="name@example.com">
                <label for="admin-login-email">Email</label>
              </div>
              <div class="form-floating mt-5 mb-5">
                <input type="password" class="form-control" id="admin-login-password" name="password" >
                <label for="admin-login-password">Password</label>
              </div>
              @error('admin-login-email')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror

              <button class="btn btn-primary mt-5 mb-5" type="submit">Submit</button>

        </form>

    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>
</html>
