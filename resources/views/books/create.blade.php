@extends('layouts.global')

@section('title')
    Create Book
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data" class="shadow-sm p-3 bg-white">
                @csrf
                <label for="title">Title</label><br>
                <input type="text" class="form-control" name="title" placeholder="Book title" id="title">
                <br>

                <label for="cover">Cover</label>
                <input type="file" name="cover" class="form-control">
                <br>

                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Give a description about this book"></textarea>
                <br>

                <label for="categories">Categories</label>
                <select name="categories[]" id="categories" class="form-control" multiple></select>
                <br><br>

                <label for="stock">Stock</label><br>
                <input type="number" class="form-control" name="stock" placeholder="Book stock" id="stock" min="0" value="0">
                <br>

                <label for="author">Author</label><br>
                <input type="text" class="form-control" name="author" placeholder="Book author" id="author">
                <br>

                <label for="publisher">Publisher</label><br>
                <input type="text" class="form-control" name="publisher" placeholder="Book publisher" id="publisher">
                <br>

                <label for="price">Price</label><br>
                <input type="number" class="form-control" name="price" placeholder="Book price" id="price">
                <br>

                <button class="btn btn-primary" name="save_action" value="PUBLISH">Publish</button>
                <button class="btn btn-secondary" name="save_action" value="DRAFT">Save as draft</button>

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
    </script>
@endsection
