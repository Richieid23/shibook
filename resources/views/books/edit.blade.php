@extends('layouts.global')

@section('title')
    Edit Book
@endsection

@section('content')
       <div class="row">
        <div class="col-md-8">
            <form action="{{ route('books.update', [$book->id]) }}" method="post" enctype="multipart/form-data" class="shadow-sm p-3 bg-white">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <label for="title">Title</label><br>
                <input type="text" class="form-control" name="title" placeholder="Book title" id="title" value="{{ $book->title }}">
                <br>

                <label for="cover">Cover</label>
                <small class="text-muted">Current Cover</small><br>
                @if ($book->cover)
                    <img src="{{ asset(Storage::url($book->cover)) }}" width="96px" alt="">
                @endif
                <br><br>
                <input type="file" name="cover" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small><br>
                <br>

                <label for="slug">Slug</label><br>
                <input type="text" class="form-control" name="slug" placeholder="enter-a-slug" id="slug" value="{{ $book->slug }}">
                <br>

                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $book->description }}</textarea>
                <br>

                <label for="categories">Categories</label>
                <select name="categories[]" id="categories" class="form-control" multiple></select>
                <br><br>

                <label for="stock">Stock</label><br>
                <input type="number" class="form-control" name="stock" placeholder="Book stock" id="stock" min="0" value="0" value="{{ $book->stock }}">
                <br>

                <label for="author">Author</label><br>
                <input type="text" class="form-control" name="author" placeholder="Book author" id="author" value="{{ $book->author }}">
                <br>

                <label for="publisher">Publisher</label><br>
                <input type="text" class="form-control" name="publisher" placeholder="Book publisher" id="publisher" value="{{ $book->publisher }}">
                <br>

                <label for="price">Price</label><br>
                <input type="number" class="form-control" name="price" placeholder="Book price" id="price" value="{{ $book->price }}">
                <br>

                <label for="">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="PUBLISH" {{ $book->status == 'PUBLISH'  ? 'selected' : '' }}>PUBLISH</option>
                    <option value="DRAFT" {{ $book->status == 'DRAFT'  ? 'selected' : '' }}>DRAFT</option>
                </select>

                <button class="btn btn-primary" value="PUBLISH">Update</button>

            </form>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        $('#categories').select2({
            ajax: {
                url: '{{ route('ajax.search') }}',
                processResults: function(data){
                    return {
                        results: data.map(function(item){
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            }
        });

        var categories = {!! $book->categories !!}

        categories.forEach(function(category){
            var option = new Option(category.name, category.id, true, true);
            $('#categories').append(option).trigger('change');
        });
    </script>
@endsection
