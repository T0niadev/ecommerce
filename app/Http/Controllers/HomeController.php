<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show products.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = auth()->user()->role_id;
        return view('home')->with([
            "products" => Product::latest()->paginate(10),
            "categories" => Category::has("products")->get(),
            "user" => User::all(),
        ]);
    }

    /**
     * Show products by category.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProductByCategory(Category $category)
    {

        $user = auth()->user()->role_id;
        $products = $category->products()->paginate(10);

        return view('home2')->with([
            "products" => $products,
            "categories" => Category::has("products")->get(),
            "user" => User::all(),
        ]);
    }

    public function shop()
    {
        $user = auth()->user()->role_id;
        return view('shop')->with([
            "products" => Product::latest()->paginate(10),
            "categories" => Category::has("products")->get(),
            "user" => User::all(),
        ]);
    }


    public function show($id)
    {
        //

        $product = Product::findOrFail($id);

        return view("products.show", compact('product'));
        // ->with([
        //     "product" => $product
        // ]);
    }

}
