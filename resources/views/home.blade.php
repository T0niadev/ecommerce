@extends('layouts.sapp')

@section('content')


<!-- Hero -->




{{-- <section class="section-header bg-primary text-white pb-7 pb-lg-9.5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-3">Latest News</h1>
                  <a href="{{ url('/posts') }}" class="lead">Know about our press release and news here</a>
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section> --}}

{{-- <section class="section-head" style="background-image: url('images/imgs.png'); background-repeat: no-repeat;background-size: 100% 100%;">
    <div class="container">
      <div class="row align-items-start align-items-md-center justify-content-end">
        <div class="col-md-3 text-center text-md-left pt-5 pt-md-0">
          {{-- <h1 class="mb-2">The Cashew Venture</h1> --}}
          {{-- <div class="intro-text text-center text-md-left">
            <p class="mb-4">The best online shopping store</p>
            <p>
              <a href="/shop" class="btn btn-lg btn-dark">Shop Now</a>
            </p>
          </div>
        </div>
      </div>
    </div>
</section> --}} --}}

<section class="section-header" style="background-image: url('images/imgs.png'); background-repeat: no-repeat;background-size: 100% 100%;">
    <div class="container">
      <div class="row align-items-start align-items-md-center justify-content-end">
        <div class="col-md-5 text-right text-xl-left pt-5 pt-md-0" style="float:right">
            {{-- <h1 class="mb-2">{{setting('home.hero_title')}}</h1> --}}
            <h1 class="mb-2">We won't get you electrocuted</h1>
            <div class="intro-text text-center text-md-left">
                {{-- <p class="mb-4">{{setting('home.hero_subtitle')}}</p> --}}
                <p class="mb-4">We sell electronic items and offer software up-gradation, wiring problems, amplifiers, motor drives, displays, connectors, adding and upgrading features, motherboards and communication boards, etc.</p>
                <p>
                <a href="/shop" class="btn btn-lg btn-black">Shop Now</a>
                </p>
            </div>
        </div>
      </div>
    </div>
</section>


<section class="section section bg-dark">
    <div class="site-section site-blocks-2">

        <div class="container">
          <div class="card bg-dark">
                <h1 class="card-header text-dark bg-soft justify-content-center align-items-center mb-5" style="text-align: center">COLLECTIONS</h1>
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
                            <a class="block-2-item" href="{{ url('category/products',$category->slug) }}">
                                <figure class="image">
                                    <img src="{{ asset($category->images) }}" class="img-fluid" style="width:80%">
                                </figure>
                                <div class="text">
                                    <span class="text-uppercase">Collections</span>
                                    <h3>{{$category->title}}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-light">
    <div class="container mb-5 mt-3">
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
    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}
        slides[slideIndex-1].style.display = "block";
        setTimeout(showSlides, 6000); // Change image every 2 seconds
        }
    </script>

@endsection

