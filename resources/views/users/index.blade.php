@extends('layouts.global')

@section('title')
    User List
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('users.index') }}">
                <div class="input-group mb-3">
                    <input type="text" name="keyword" value="{{ Request::get('keyword') }}" class="form-control col-md-10" placeholder="Filter berdasarkan email">
                    <div class="input-group-append">
                        <input type="submit" value="Filter" class="brn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-right">
            <a href="{{ route('users.create') }}" class="btn btn-primary">Create User</a>
        </div>
    </div>
    <br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><b>Name</b></th>
                <th><b>Usename</b></th>
                <th><b>Email</b></th>
                <th><b>Avatar</b></th>
                <th><b>Action</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->avatar)
                            <img src="{{ asset(Storage::url($user->avatar)) }}" width="70px" alt="">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-info text-white btn-sm">Edit</a>
                        <a href="{{ route('users.show', [$user->id]) }}" class="btn btn-primary btn-sm">Detail</a>
                        <form action="{{ route('users.destroy', $user->id) }}" class="d-inline" method="POST" onsubmit="return confirm('Delete this user permanently?')">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection