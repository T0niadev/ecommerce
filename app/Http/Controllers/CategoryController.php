<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware("auth:admin")->except([
            "index", "show"
        ]);
    }


     public function index()
    {
        //
        // return view('home')->with([
        //     "categories" => Category::all
        // ]);


        return view("admin.category.index", compact('categories', 's'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.category.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required|min:3",
            "slug" => "required|min:3",
        ]);

        $title = $request->title;

        Category::create([
            "title" => $title,
            "slug" => Str::slug($title),
        ]);
        // return redirect()->url('admin/category')
        //     ->withSuccess("Product added");

        return redirect('/admin/category')->withSuccess('Category succesfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view("category.show")->with([
            "category" => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit(Category $category)
    // {
    //     //
    //       //
    //       return view("admin.category.edit")->with([
    //         "category" => $category,


    //     ]);
    // }

    public function edit($id)
    {
        //
        // return view("admin.products.edit")->with([
        //     "product" => $product,
        //     "categories" => Category::all()
        // ]);
        return view("admin.category.edit")->with([
            "category" => Category::findOrFail($id),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Category $category, $id)
    {

           //validation
           $this->validate($request, [
            "title" => "required|min:3",
            "slug" => "required|min:3",

        ]);
        $category = Category::findOrFail($id);
        $title = $request->title;
        $category->update([
            "title" => $title,
            "slug" => Str::slug($title),
        ]);
        return redirect('/admin/category')
            ->withSuccess("Category updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect('/admin/category')
            ->withSuccess("Category deleted");
    }


    // public function scopeSearch($query, $s)
    // {
    // return $query->where('title', 'like', '%'.$s.'%')
    //     ->orwhere('slug', 'like', '%'.$s.'%');
    //     // ->orwhere('customer_address', 'like', '%'.$s.'%');
    // }


    public function search(Request $request)
    {
        $title = $request->title;
        $slug = $request->slug;
        $category = Category::where('title', 'like', '%'.$title.'%')->where('slug', 'like', '%'.$slug.'%')
        ->orderBy('title')
        ->paginate(5);

        return view('admin.category.index')
            ->with('category', $category);
   }
}


