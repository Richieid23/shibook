<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $keyword = $request->keyword ? $request->keyword : '';

        if ($status) {
            $books = Book::with('categories')->where('title', 'LIKE', "%$keyword%")->where('status', strtoupper($status))->paginate(10);
        } else {
            $books = Book::with('categories')->where('title', 'LIKE', "%$keyword%")->paginate(10);
        }

        return view('books.index', [
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_book = new Book;

        $new_book->title = $request->title;
        $new_book->description = $request->description;
        $new_book->author = $request->author;
        $new_book->publisher = $request->publisher;
        $new_book->price = $request->price;
        $new_book->stock = $request->stock;
        $new_book->status = $request->save_action;

        $new_book->categories()->attach($request->categories);

        if ($request->cover) {
            $new_book->cover = $request->file('cover')->store('book-covers', 'public');
        }

        $new_book->slug = Str::slug($request->title);
        $new_book->created_by = Auth::user()->id;

        $new_book->save();

        if ($request->save_action == 'PUBLISH') {
            return redirect()->route('books.index')->with('status', 'Book Succesfully Saved and Published');
        } else {
            return redirect()->route('books.index')->with('status', 'Book Saved as Draft');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('books.edit', [
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->price = $request->price;
        $book->stock = $request->stock;
        $book->status = $request->save_action;

        $book->categories()->attach($request->categories);

        if ($request->cover) {
            if ($book->cover && file_exists(storage_path('app/public/' . $book->cover))) {
                Storage::delete('public' . $book->cover);
            }
            $book->cover = $request->file('cover')->store('book-covers', 'public');
        }

        $book->slug = $request->slug;
        $book->updated_by = Auth::user()->id;
        $book->status = $request->status;

        $book->save();

        $book->categories()->sync($request->categories);

        return redirect()->route('books.index')->with('status', 'Book Succesfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')->with('status', 'Book Succesfully Moved to Trash');
    }

    public function trash()
    {
        $books = Book::onlyTrashed()->paginate(10);

        return view('books.trash', [
            'books' => $books
        ]);
    }

    public function restore($id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        if ($book->trashed()) {
            $book->restore();
            return redirect()->route('books.index')->with('status', 'Book Successfully Restored');
        } else {
            return redirect()->route('books.index')->with('status', 'Book is not in trash');
        }
    }

    public function deletePermanent($id)
    {
        $book = Book::withTrashed()->findOrFail($id);

        if (!$book->trashed()) {
            return redirect()->route('books.trash')->with('status', 'Can not delete permanent active Book')->with('status_type', 'alert');
        } else {
            $book->categories()->detach();
            $book->forceDelete();

            return redirect()->route('books.trash')->with('status', 'Book permanently deleted');
        }
    }
}
