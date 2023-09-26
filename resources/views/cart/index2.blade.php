@extends('layouts.sapp')

@section('title', 'Cart')

@section('content')

    <!-- Hero -->
    <section class="section-header bg-primary text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 text-center">
                    <h1 class="display-2 mb-3">Cart</h1>
                    <p class="lead">See your cart items</p>
                </div>
            </div>
        </div>
    </section>


    @if ( Cart::isEmpty())

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">No Items to show</h2>
                <a href="/shop" class="btn btn-lg btn-primary mt-3">Return to shop</a>
            </div>
        </div>
    </div>
    @else

    <div class="pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                        <!-- Shopping cart table -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="p-2 px-3 text-uppercase">Image</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="p-2 px-3 text-uppercase">Product</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Price</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Quantity</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Subtotal</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Remove</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)

                                        <tr>
                                            <td>
                                                <img src="{{ asset($item->associatedModel->image) }}" class="cart-image" alt="{{ $item->title }}">
                                            <td>
                                            <td scope="row" class="border-0">
                                                <div class="p-2">
                                                    <div class="ml-3 d-inline-block align-middle">
                                                        <h5 class="mb-0"> <a href="/product/" class="text-dark d-inline-block align-middle">{{ $item->title }}</a></h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-0 align-middle">
                                                {{ $item->price }} Naira
                                            </td>
                                            <td class="border-0 align-middle">
                                                <form class="d-flex flex-row justify-content-center align-items-center" action="{{ url('update/cart',$item->associatedModel->slug) }}" method="post">
                                                    @csrf
                                                    @method("PUT")
                                                    <div class="form-group">
                                                        <input type="number" name="qty" id="qty"
                                                            value="{{ $item->quantity }}"
                                                            placeholder="Quantité"
                                                            max="{{ $item->associatedModel->inStock }}"
                                                            min="1"
                                                            class="form-control"
                                                        >
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-sm btn-warning">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="border-0 align-middle">
                                                {{ $item->price * $item->quantity}} Naira
                                            </td>
                                            <td>
                                                <form class="d-flex flex-row justify-content-center align-items-center" action="{{ url('/remove/{product}/cart',$item->associatedModel->slug) }}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            </tr>
                                        </tr>
                                    @endforeach
                                    <tr class="text-dark font-weight-bold" >
                                        <td colspan="3" >
                                            Total
                                        </td>
                                        <td colspan="3" >
                                            {{ Cart::getSubtotal() }} Naira
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @if(Cart::getSubtotal() > 0)
                                <div class="form-group">
                                    <a href="{{ url('/handle-payment') }}" class="btn btn-dark mt-3">
                                        Pay {{ Cart::getSubtotal() }} Naira via PayPal
                                    </a>
                                </div>
                           @endif
                        </div>
                        <!-- End -->
                        <div class="row">
                            <div class="col-12 col-md-3 ml-3 mt-3">
                                <a href="{{ url('cart.removeall') }}" class="btn btn-primary  py-2 btn-block">Remove all</a>
                            </div>
                            <div class="col-12 col-md-3 ml-3 mt-3">
                                <button id="updatecart" class="btn btn-primary  py-2 btn-block">Update Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row py-5 p-4 bg-white rounded shadow-sm">
                    <div class="col-lg-6">
                        <div class="bg-light  px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
                            <div class="p-4">
                                <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>

                                <form action="{{url('/add-discount')}}" method="get">
                                    @csrf
                                    <div class="input-group mb-4 border  p-2">
                                        <input type="text" name="discount" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0">
                                        <div class="input-group-append border-0">
                                            <button type="submit" class="btn btn-primary px-4 "><i class="fa fa-gift mr-2"></i>Apply coupon</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="bg-light  px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
                            <div class="p-4">
                                <ul class="list-unstyled mb-4">
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Subtotal</strong><strong>{{ Cart::getSubtotal() }}</strong></li>
                                    <li class="d-flex justify-content-between py-3 border-bottom">
                                        <strong class="text-muted">Discount
                                            @if(count(Cart::getConditionsByType('coupon'))!=0)
                                            ({{Cart::getConditionsByType('coupon')->first()->getName()}}) <a href="/cart/discountremove">remove</a>
                                            @endif
                                        </strong>
                                        <strong>{{count(Cart::getConditionsByType('coupon'))==0?'0':two_decimal(Cart::getConditionsByType('coupon')->first()->getCalculatedValue())}}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Subtotal (after discount)</strong><strong>{{Cart::getSubTotal()}}</strong></li>
                                    <?php $cartConditions = Cart::getConditions(); ?>
                                    @if (count($cartConditions)>0)
                                        @foreach($cartConditions as $condition)
                                            @if ($condition->getType()!='coupon')
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">{{$condition->getName()}}</strong><strong>{{two_decimal($condition->getCalculatedValue(Cart::getSubTotal()))}}</strong></li>
                                            @endif
                                        @endforeach
                                    @endif
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                                        <h5 class="font-weight-bold">{{Cart::getTotal()}}</h5>
                                    </li>
                                </ul>
                                <a href="/checkout" class="btn btn-primary  py-2 btn-block">Procceed</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@section ('javascript')
    <script src="/frontend/assets/js/cart.js"></script>
@stop
