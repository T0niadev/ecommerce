@extends('layouts.sapp')

@section('content')

    <!-- Hero -->
    <section class="section-header bg-dark text-white">
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
                    <a href="/shop" class="btn btn-lg btn-dark mt-3">Return to shop</a>
                </div>
            </div>
        </div>
    @else
    <div class="container mt-7">
        <div class="row">
            <div class="col-md-12 card p-3">
               <div class="card-header bg-dark">
                  <h4 class="text-white">Your cart</h4>
                  <a
                    href="{{ url('/add/cart/{product}') }}"
                    class="btn btn-white col-md-1" >
                    <i class="fa fa-plus"></i>
                </a>
               </div>


                <table class="table mt-3 bg-soft"  style="colour : #ADD8E6">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach ($items as $item)
                            <tr bg-dark>
                                <td>
                                    <img src="{{ asset($item->associatedModel->image) }}"
                                        alt="{{ $item->title }}"
                                        width="50"
                                        height="50"
                                        class="img-fluid rounded"
                                    >
                                </td>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
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
                                <td>
                                    {{ $item->price }} Naira
                                </td>
                                <td>
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
                {{-- @if(Cart::getSubtotal() > 0)
                    <div class="form-group">
                        <a href="{{ url('/handle-payment') }}" class="btn btn-dark mt-3">
                            Pay {{ Cart::getSubtotal() }} Naira via PayPal
                        </a>
                    </div>
                @endif --}}
            </div>

            <div class= "container">
                <div class="row py-5 p-4 rounded shadow-sm">
                    <div class="col-lg-6 ">
                        <div class="bg-light  px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
                            <div class="p-4 bg-soft">
                                <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>

                                <form action="{{url('/add-discount')}}" method="get">
                                    @csrf
                                    <div class="input-group mb-4 border  p-2">
                                        <input type="text" name="discount" placeholder="Apply coupon" aria-describedby="button-addon3" class="form-control border-0">
                                        <div class="input-group-append border-0">
                                            <button type="submit" class="btn btn-dark px-4 "><i class="fa fa-gift mr-2"></i>Apply coupon</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="bg-light  px-4 py-3 text-uppercase font-weight-bold">Order summary </div>
                            <div class="p-4 bg-soft">
                                <ul class="list-unstyled mb-4">
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Subtotal</strong><strong> {{ Cart::getSubtotal() }} Naira</strong></li>
                                    <li class="d-flex justify-content-between py-3 border-bottom">
                                        <strong class="text-muted">Discount
                                            @if(count(Cart::getConditionsByType('coupon'))!=0)
                                            ({{Cart::getConditionsByType('coupon')->first()->getName()}}) <a href="/cart/discountremove">remove</a>
                                            @endif
                                        </strong>
                                        <strong>{{count(Cart::getConditionsByType('coupon'))==0?'0':two_decimal(Cart::getConditionsByType('coupon')->first()->getCalculatedValue())}} Naira</strong>
                                    </li>
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Subtotal (after discount)</strong><strong> {{Cart::getSubTotal()}} Naira</strong></li>
                                    <?php $cartConditions = Cart::getConditions(); ?>
                                    @if (count($cartConditions)>0)
                                        @foreach($cartConditions as $condition)
                                            @if ($condition->getType()!='coupon')
                                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">{{$condition->getName()}}</strong><strong>{{two_decimal($condition->getCalculatedValue(Cart::getSubTotal()))}}</strong></li>
                                            @endif
                                        @endforeach
                                    @endif
                                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                                        <h5 class="font-weight-bold">{{Cart::getTotal()}} Naira</h5>
                                    </li>
                                </ul>
                                @if(Cart::getSubtotal() > 0)
                                <a href="{{ url('/handle-payment') }}" class="btn btn-dark  py-2 btn-block">Procceed (Pay {{ Cart::getSubtotal() }} Naira via Paypal)</a>
                                @endif
                            </div>
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
