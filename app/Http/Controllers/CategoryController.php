<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::paginate(10);

        $filterKeyword = $request->name;

        if ($filterKeyword) {
            $categories = Category::where('name', 'LIKE', "%$filterKeyword%")->paginate(10);
        }

        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->image) {
            $data['image'] = $request->file('image')->store('category_images', 'public');
        }

        $data['created_by'] = Auth::user()->id;

        $data['slug'] = Str::slug($request->name, '-');

        Category::create($data);

        return redirect()->route('categories.index')->with('status', 'Category Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $category = Category::findOrFail($id);

        if ($request->image) {
            if ($category->image && file_exists(storage_path('app/public/' . $category->image))) {
                Storage::delete('public/' . $category->image);
            }
            $data['image'] = $request->file('image')->store('category_images', 'public');
        }

        $data['updated_by'] = Auth::user()->id;

        $data['slug'] = Str::slug($request->name, '-');

        $category->update($data);

        return redirect()->route('categories.index')->with('status', 'Category Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category Successfully Moved to Trash');
    }

    public function trash()
    {
        $deleted_category = Category::onlyTrashed()->paginate(10);

        return view('categories.trash', [
            'categories' => $deleted_category
        ]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if ($category->trashed()) {
            $category->restore();
        } else {
            return redirect()->route('categories.index')->with('status', 'Category is not in trash');
        }

        return redirect()->route('categories.index')->with('status', 'Category Successfully Restored');
    }

    public function deletePermanent($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if (!$category->trashed()) {
            return redirect()->route('categories.index')->with('status', 'Can not delete permanent active category');
        } else {
            $category->forceDelete();

            return redirect()->route('categories.index')->with('status', 'Category permanently deleted');
        }
    }
}
