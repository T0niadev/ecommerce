@extends('layouts.sapp')

@section('title','About')

@section('content')
<!-- Hero -->
<section class="section-header pb-8 pb-lg-13 mb-4 mb-lg-6 bg-dark text-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-3">Know more about us</h1>
                <p class="lead">Know about us how we started our journey </p>
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section>
<section class="section section-lg pt-0">
    <div class="container mt-n7 mt-lg-n13 z-2">
        <div class="row justify-content-center">
            <div class="card bg-white border-light shadow-soft flex-md-row no-gutters p-4">
                <a class="col-md-6 col-lg-6"><img src="{{ url('/images/images.jpeg')}}" alt="img" class="card-img-top" /></a>
                <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">
                    <h2>About Us</h2>

                    We are a reputable brand
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
