@extends('layouts.sapp')

@section('title', 'Shop')


<section class="bg-light">
    <div class="container mb-5 mt-6">
        <div class="row">
            <div class="col-md-10">
                <div class="card bg-light">
                    <h3 class="card-header text-white bg-dark mt-4">Latest Products </h3>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-md-4 mb-2 shadow-sm">
                                    <div class="card" style="width:18rem,height:100%">
                                        <div class="card-img-top" style="width:100%">
                                            <img class="img-fluid rounded" src="{{ asset($product->image) }}"
                                                alt="{{ $product->title }}">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                {{ $product->title }}
                                            </h5>
                                            <p class="d-flex flex-row justify-content-between align-items-center">
                                                <span class="text-muted">
                                                    {{ $product->price }} Naira
                                                </span>
                                                <span class="text-danger">
                                                    <strike>
                                                        {{ $product->old_price }} Naira
                                                    </strike>
                                                </span>
                                            </p>
                                            <p class="card-text">
                                                {{ Str::limit($product->description,100) }}
                                            </p>
                                            <a href="{{ url('products/show',$product->id) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="justify-content-center d-flex">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2" >
                <div class="list-group" >
                    <li class="list-group-item active bg-dark mt-4">
                        Categories
                    </li>
                    @foreach ($categories as $category)
                        <a href="{{ url('category/products',$category->slug) }}"
                            class="list-group-item list-group-item-action" style="border-bottom: 1px solid #FFFF00">
                            {{ $category->title }}
                            ({{ $category->products->count() }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
