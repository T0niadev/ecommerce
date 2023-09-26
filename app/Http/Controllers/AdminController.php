<?php

namespace App\Http\Controllers;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Admin;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin')
            ->except(["showAdminLoginForm", "adminLogin"]);
    }

    public function index()
    {
        return view("admin.index")->with([
            "products" => Product::all(),
            "orders" => Order::all()
        ]);
    }

    public function showAdminLoginForm()
    {
        return view("admin.auth.login");
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        if (auth()->guard("admin")->attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->get("remember"))) {
            return redirect("/admin");
        } else {
            // return redirect()->route("admin.login");
            return redirect("admin/login");
        }
        // return redirect("/admin");
    }

    public function adminLogout()
    {
        auth()->guard("admin")->logout();
        return redirect()->route("admin.login");
    }

    public function getProducts()
    {
        return view("admin.products.index")->with([
            "products" => Product::latest()->paginate(5)
        ]);
    }

    public function getOrders()
    {
        return view("admin.orders.index")->with([
            "orders" => Order::latest()->paginate(5)
        ]);
    }

    public function getCategory()
    {
        return view("admin.category.index")->with([
            "category" => category::latest()->paginate(5)
        ]);
    }

    public function getPost()
    {
        return view("admin.posts.index")->with([
            "category" => category::latest()->paginate(5)
        ]);
    }

    public function productcreate()
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
    public function productstore(Request $request)
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
    public function productedit($id)
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
    public function productupdate(Request $request, Product $product, $id)
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
    public function productdestroy(Product $product, $id)
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

    public function productsearch(Request $request)
    {
      $title = $request->title;
      $description = $request->description;
      $products = Product::where('title', 'like', '%'.$title.'%')->where('description', 'like', '%'.$description.'%')
     ->orderBy('title')
     ->paginate(5);

       return view('admin.products.index')
         ->with('products', $products);
    }
    public function categorycreate()
    {
        //
        return view("admin.category.create");
    }
    public function categorystore(Request $request)
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
    public function categoryedit($id)
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
    public function categoryupdate(Request $request, Category $category, $id)
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
    public function categorydestroy(Category $category, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect('/admin/category')
            ->withSuccess("Category deleted");
    }
    public function categorysearch(Request $request)
    {
    $title = $request->title;
    $slug = $request->slug;
    $category = Category::where('title', 'like', '%'.$title.'%')->where('slug', 'like', '%'.$slug.'%')
    ->orderBy('title')
    ->paginate(5);

    return view('admin.category.index')
        ->with('category', $category);
   }

   public function postindex()
   {
     {
          $post = Post::all();

          return view('admin.posts.index',compact('post'));
       }
   }

   public function postcreate()
   {
       //
       return view("admin.posts.create");
   }

   public function poststore(Request $request)
   {
       $this->validate($request, [
           "title" => "required|min:3",
           "excerpt" => "required|min:3",
           "image" => "required|image|mimes:png,jpg,jpeg|max:2048",
           "links" => "required|min:3",
           "status" => "nullable",
           "featured" => "nullable",
           "authorID" => "nullable"

       ]);
       if ($request->has("image")) {
           $file = $request->image;
           $imageName = "images/posts/" . time() . "_" . $file->getClientOriginalName();
           $file->move(public_path("images/posts"), $imageName);
           $title = $request->title;


         Post::create([
               "title" => $title,
               "slug" => Str::slug($title),
               "excerpt" => $request->excerpt,
               "image" => $imageName,
               "links" => $request->links,
               "status" => $request->status,
               "featured" =>$request->featured,
               "authorID" => $request->authorID
           ]);
       }


       return redirect('/admin/posts')->withSuccess('Post succesfully added');
   }

   public function postedit($id)
   {

       return view("admin.posts.edit")->with([
           "post" => Post::findOrFail($id),

       ]);
   }


   public function postupdate(Request $request, Post $post, $id)
   {
       $post = Post::find($id);
       $this->validate($request, [
           // "title" => "required|min:3"
           // "excerpt" => "required|min:5",
           // "image" => "image|mimes:png,jpg,jpeg|max:2048"
       ]);

       $input = $request->all();

       if ($image = $request->file('image')) {
           $destinationPath = 'images/posts';
           $file = $request->image;
           $profileImage = "images/posts/" . time() . "_" . $file->getClientOriginalName();
           $image->move($destinationPath, $profileImage);
           $input['image'] = "$profileImage";
       }else{
           unset($input['image']);
       }

       $title = $request->title;
       $post->update($input);

       // $post->update([
       //    "title" => $title,
       //    "slug" => Str::slug($title),
       //    "excerpt" => $request->excerpt,
       //     "links" => $request->links,
       //     "status" => $request->status,
       //     "featured" =>$request->featured,
       //     "authorID" => $request->authorID,
       // ]);

       return redirect('/admin/posts')
       ->withSuccess("Post updated");
   }


   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Post  $post
    * @return \Illuminate\Http\Response
    */
   public function postdestroy(Post $post, $id)
   {
       //delete data
       $post = Post::findOrFail($id);
       $image_path = public_path("images/posts/" . $post->image);
       if (File::exists($image_path)) {
           unlink($image_path);
       }
       $post->delete();
       return redirect('/admin/posts')
           ->withSuccess("Post deleted");
   }

}
