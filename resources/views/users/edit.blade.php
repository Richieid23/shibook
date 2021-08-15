@extends('layouts.global')

@section('title')
    Edit User
@endsection

@section('content')
    <div class="col-md-8">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('users.update', [$user->id]) }}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <label for="name">Name</label>
            <input type="text" class="form-control" placeholder="Full Name" name="name" id="name" value="{{ $user->name }}">
            <br>

            <label for="username">Username</label>
            <input type="text" class="form-control" placeholder="Username" name="username" id="username" value="{{ $user->username }}">
            <br>

            <label for="">Status</label>
            <br>
            <input {{ $user->status == 'ACTIVE' ? 'Checked' : '' }} type="radio" name="status" id="active" class="form-control" value="ACTIVE">
            <label for="active">Active</label>
            <input {{ $user->status == 'INACTIVE' ? 'Checked' : '' }} type="radio" name="status" id="inactive" class="form-control" value="INACTIVE">
            <label for="inactive">Inactive</label>
            <br>

            <label for="">Roles</label>
            <br>
            <input {{ in_array('ADMIN', json_decode($user->roles)) ? 'checked' : '' }} type="checkbox" name="roles[]" id="ADMIN" value="ADMIN">
            <label for="ADMIN">Administrator</label>

            <input {{ in_array('STAFF', json_decode($user->roles)) ? 'checked' : '' }} type="checkbox" name="roles[]" id="STAFF" value="STAFF">
            <label for="STAFF">Staff</label>

            <input {{ in_array('CUSTOMER', json_decode($user->roles)) ? 'checked' : '' }} type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER">
            <label for="CUSTOMER">Customer</label>
            <br>

            <br>
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" placeholder="Phone Number" name="phone" id="phone" value="{{ $user->phone }}">
            <br>

            <label for="address">Address</label>
            <textarea class="form-control"name="address" id="address">{{ $user->address }}</textarea>

            <br>
            <label for="avatar">Avatar Image</label>
            <br>
            Current avatar: <br>
            @if ($user->avatar)
                <img src="{{ asset(Storage::url($user->avatar)) }}" width="120px" alt="">
            @else
                No Avatar
            @endif
            <br>
            <input type="file" name="avatar" id="avatar" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>

            <hr class="my-3">

            <label for="email">Email</label>
            <input type="email" class="form-control" placeholder="user@mail.com" name="email" id="email" value="{{ $user->email }}" disabled>
            <br>

            <input type="submit" class="btn btn-primary" value="Save">
        </form>
    </div>
@endsection
