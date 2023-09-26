@extends('layouts.sapp')

@section('title', 'Posts')

@section('content')

<!-- Hero -->
<section class="section-header bg-dark text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">Latest News</h1>
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section>
<section class="section section-lg line-bottom-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <!-- <div class="row"> -->
            <div class="col-lg-12 mb-5">

                <div class="card bg-light border-light shadow-soft flex-md-row no-gutters p-4">
                    <a href="/post/{{$latestPost->slug}}" class="col-md-6 col-lg-6"><img src="{{ asset($latestPost->image) }}" alt="post-img" class="card-img-top" /></a>
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">
                         <a href="/post/{{$latestPost->slug}}"><h2>{{$latestPost->title}}</h2></a>
                          <p class="md-2">
                             {{Str::words($latestPost->excerpt,20)}}
                           </p>
                           <div class="d-flex align-items-center">
                               <img class="avatar avatar-sm rounded-circle" src="{{is_null($latestPost->authorId)?'/frontend/img/default.png':Voyager::image($latestPost->authorId->avatar)}}" alt="avatar" />
                               <h6 class="text-muted small ml-2 mb-0">{{is_null($latestPost->authorId)?'Admin':$latestPost->authorId->name}}</h6>
                               <h6 class="text-muted small font-weight-normal mb-0 ml-auto"><time datetime="2019-04-25">{{$latestPost->created_at->diffForHumans()}}</time></h6>
                           </div>
                      </div>
                  </div>





                   <div class="card-deck mt-4">
                       @foreach ($post as $post)
                            <div class="card bg-light border-light shadow-soft p-4 rounded">
                                <a href="/post/{{$post->slug}}"><img src="" class="card-img-top" alt="{{ $post->title }}"/></a>
                                <div class="card-body p-0 pt-4">
                                <a href="/post/{{$post->slug}}" class="h3">{{$post->title}}</a>

                                <div class="d-flex align-items-center my-4">


                                    </div>
                                    <p class="mb-0">
                                    {{Str::words($post->excerpt,10)}}
                                    </p>

                                    <img class="avatar avatar-sm rounded-circle mt-2" src="{{is_null($post->authorId)?'/frontend/img/default.png':Voyager::image($post->authorId->avatar)}}" alt="avtar" />
                                    <h6 class="text-muted small ml-2 mb-0">{{is_null($post->authorId)?'Admin':$post->authorId->name}}</h6>

                                    <div class="d-flex justify-content-center w-100 mt-3">
                                    <nav aria-label="Page navigation example">
                                        {{$post->links}}
                                    </nav>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>



            </div>


        <!-- </div> -->
    </div>
</section>


@endsection
