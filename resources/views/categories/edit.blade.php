@extends('layouts.global')

@section('title')
    Edit Category
@endsection

@section('content')
    <div class="col-md-8">
        <form action="{{ route('categories.update', [$category->id]) }}" method="post" enctype="multipart/form-data" class="bg-white shadow-sm p-3">
            @csrf

            <input type="hidden" value="PUT" name="_method">

            <label>Category Name</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control">
            <br><br>

            <label>Category Slug</label>
            <input type="text" class="form-control" value="{{ $category->slug }}" name="slug">
            <br><br>

            @if ($category->image)
                <span>Current Image</span><br>
                <img src="{{ asset(Storage::url($category->image)) }}" alt="" width="120px">
                <br><br>
            @endif

            <input type="file" class="form-control" name="image">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
            <br><br>

            <input type="submit" class="btn btn-primary" value="Update">
        </form>
    </div>
@endsection
