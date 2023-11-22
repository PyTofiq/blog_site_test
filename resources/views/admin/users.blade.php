@extends('admin.layout.master')



@section('content')
<div class="container">

    <h2>Users table</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Status</th>
            </tr>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->status ? 'Admin' : 'Author' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </thead>
    </table>
</div>


@endsection
