<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    //return cart items
    public function index()
    {
        return view("cart.index")->with([
            "items" => \Cart::getContent()
        ]);
    }

    //add item to cart
    public function addProductToCart(Request $request, Product $product)
    {
        \Cart::add(array(
            "id" => $product->id,
            "name" => $product->title,
            "price" => $product->price,
            "quantity" => $request->qty,
            "attributes" => array(),
            "associatedModel" => $product,
        ));
        // return redirect()->route("cart.index");
        return redirect('/cart')->with('message', 'Item succesfully added to cart');
    }

    //update item on cart
    public function updateProductOnCart(Request $request, Product $product)
    {
        \Cart::update($product->id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->qty
            ),
        ));
        return redirect()->route("cart.index");
    }

    //remove item from cart
    public function removeProductFromCart(Product $product)
    {
        \Cart::remove($product->id);
        return redirect()->route("cart.index");
    }

    public function addDiscount(Request $request){
        $request->validate([
            'discount'=>'required'
        ]);


        $coupon=Coupon::where('code',$request->discount)->where('status','active')->first();

        if(!$coupon){
            notify()->error('Invalid coupon');
            return back();
        }
        Cart::removeConditionsByType('coupon');

        if($coupon->type=='fixed'){
            $amount=$coupon->amount;
        }
        else{
            $amount=($coupon->amount).'%';
        }
        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => $coupon->code,
            'type' => 'coupon',
            'target' => 'subtotal', // this condition will be applied to cart's total when getTotal() is called.
            'value' => '-'.$amount,
        ));
        Cart::condition($condition);
        notify()->success('Coupon added');
        return back();

    }

    public function discountRemove(){
        Cart::removeConditionsByType('coupon');
        notify()->success('Coupon removed');
        return back();
    }
    public function rowItemRemove($rowId){
        Cart::remove($rowId);
        notify()->success('Item removed');
        return back();
    }
}
