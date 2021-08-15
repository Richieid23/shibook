@extends('layouts.global')

@section('title')
    Create User
@endsection

@section('content')
    <div class="col-md-8">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf

            <label for="name">Name</label>
            <input type="text" class="form-control" placeholder="Full Name" name="name" id="name">
            <br>

            <label for="username">Username</label>
            <input type="text" class="form-control" placeholder="Username" name="username" id="username">
            <br>

            <label for="">Roles</label>
            <br>
            <input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN">
            <label for="ADMIN">Administrator</label>

            <input type="checkbox" name="roles[]" id="STAFF" value="STAFF">
            <label for="STAFF">Staff</label>

            <input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER">
            <label for="CUSTOMER">Customer</label>
            <br>

            <br>
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" placeholder="Phone Number" name="phone" id="phone">
            <br>

            <label for="address">Address</label>
            <textarea class="form-control"name="address" id="address"></textarea>

            <br>
            <label for="avatar">Avatar Image</label>
            <br>
            <input type="file" name="avatar" id="avatar" class="form-control">

            <hr class="my-3">

            <label for="email">Email</label>
            <input type="email" class="form-control" placeholder="user@mail.com" name="email" id="email">
            <br>

            <label for="password">Password</label>
            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
            <br>

            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" class="form-control" placeholder="Password" name="password_confirmation" id="password_confirmation">
            <br>

            <input type="submit" class="btn btn-primary" value="Save">
        </form>
    </div>
@endsection
