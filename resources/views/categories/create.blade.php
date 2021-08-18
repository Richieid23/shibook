@extends('layouts.global')

@section('title')
    Create Category
@endsection

@section('content')
    <div class="col-md-8">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf

            <label>Category Name</label>
            <input type="text" class="form-control" placeholder="Category Name" name="name">
            <br>

            <label>Category Image</label>
            <input type="file" name="image" class="form-control">
            <br>

            <input type="submit" class="btn btn-primary" value="Save">
        </form>
    </div>
@endsection
