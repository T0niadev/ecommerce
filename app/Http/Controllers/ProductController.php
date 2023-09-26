<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin")->except([
            "index", "show"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('home')->with([
            "products" => Product::latest()->paginate(10),
            "categories" => Category::has("products")->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.products.create")->with([
            "categories" => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $this->validate($request, [
            "title" => "required|min:3",
            "description" => "required|min:5",
            "image" => "required|image|mimes:png,jpg,jpeg|max:2048",
            "price" => "required|numeric",
            "category_id" => "required|numeric",
        ]);

        //add data
        if ($request->has("image")) {
            $file = $request->image;
            $imageName = "images/products/" . time() . "_" . $file->getClientOriginalName();
            $file->move(public_path("images/products"), $imageName);
            $title = $request->title;

            Product::create([
                "title" => $title,
                "slug" => Str::slug($title),
                "description" => $request->description,
                "price" => $request->price,
                "old_price" => $request->old_price,
                "inStock" => $request->inStock,
                "category_id" => $request->category_id,
                "image" => $imageName,
            ]);
            // return redirect()->route('admin/products')
            //     ->withSuccess("Product added");

            return redirect('/admin/products')->withSuccess ("Product succesfully added");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //

    //     $product = Product::findOrFail($id);

    //     return view("products.show", compact('product'));
    //     // ->with([
    //     //     "product" => $product
    //     // ]);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // return view("admin.products.edit")->with([
        //     "product" => $product,
        //     "categories" => Category::all()
        // ]);
        return view("admin.products.edit")->with([
            "product" => Product::findOrFail($id),
            "categories" => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Product $product, $id)
    // {
    //     //validation
    //     $this->validate($request, [
    //         "title" => "required|min:3",
    //         "description" => "required|min:5",
    //         // "image" => "image|mimes:png,jpg,jpeg|max:2048",
    //         "price" => "required|numeric",
    //         "category_id" => "required|numeric",
    //     ]);

    //     //update data
    //     $product = Product::findOrFail($id);
    //     // if ($request->has("image")) {
    //     //     $image_path = public_path("images/products/" . $product->image);
    //     //     if (File::exists($image_path)) {
    //     //         unlink($image_path);
    //     //     }
    //     //     $file = $request->image;
    //     //     $imageName = "images/products/" . time() . "_" . $file->getClientOriginalName();
    //     //     $file->move(public_path("images/products"), $imageName);
    //     //     $product->image = $imageName;
    //     // }

    //     if ($request->hasFile("image")) {
    //         // unlink(public_path('images/products' . $product->image));
    //         $file = $request->image;
    //         $imageName = "images/products/" . time() . "_" . $file->getClientOriginalName();
    //         $file->move(public_path('images/products'), $imageName);
    //         $product->image = $imageName;
    //     }

    //     $title = $request->title;
    //     $product->update([
    //         "title" => $title,
    //         "slug" => Str::slug($title),
    //         "description" => $request->description,
    //         "price" => $request->price,
    //         "old_price" => $request->old_price,
    //         "inStock" => $request->inStock,
    //         "category_id" => $request->category_id,
    //         "image" =>  $product->image,
    //     ]);
    //     return redirect('/admin/products')
    //         ->withSuccess("Product updated");
    // }


    public function update(Request $request, Product $product, $id)
    {
        $product = Product::find($id);
        $this->validate($request, [
            // "title" => "required|min:3"
            // "excerpt" => "required|min:5",
            // "image" => "image|mimes:png,jpg,jpeg|max:2048"
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/products';
            $file = $request->image;
            $profileImage = "images/products/" . time() . "_" . $file->getClientOriginalName();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        // $title = $request->title;
        $product->update($input);

        // $post->update([
        //    "title" => $title,
        //    "slug" => Str::slug($title),
        //    "excerpt" => $request->excerpt,
        //     "links" => $request->links,
        //     "status" => $request->status,
        //     "featured" =>$request->featured,
        //     "authorID" => $request->authorID,
        // ]);

        return redirect('/admin/products')
        ->withSuccess("Product updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        //delete data
        $product = Product::findOrFail($id);
        $image_path = public_path("images/products/" . $product->image);
        if (File::exists($image_path)) {
            unlink($image_path);
        }
        $product->delete();
        return redirect('/admin/products')
            ->withSuccess("Product deleted");
    }

    public function search(Request $request)
    {
      $title = $request->title;
      $description = $request->description;
      $products = Product::where('title', 'like', '%'.$title.'%')->where('description', 'like', '%'.$description.'%')
     ->orderBy('title')
     ->paginate(5);

       return view('admin.products.index')
         ->with('products', $products);
    }
}
