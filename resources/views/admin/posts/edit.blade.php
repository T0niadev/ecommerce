@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include("layouts.sidebar")
        </div>
        <div class="col-md-8">
            <div class="card p-3">
                <h3 class="card-title">Update {{ $post->title }}</h3>
                <div class="card-body">
                    <form method="post" action="{{ url(  'admin/posts/update', $post->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <input type="text"
                            name="post"
                            placeholder="post"
                            value="{{ $post->title }}"
                            class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="text"
                            name="excerpt"
                            placeholder="excerpt"
                            value="{{ $post->excerpt }}"
                            class="form-control">
                        </div>


                        <div class="form-group">
                            <input type="file"
                            name="image"
                            class="form-control">
                        </div>

                        <div class="form-group">
                            <select name="status" class="form-control">
                              <option value="published" {{ $post->status == "published" ? 'selected':""}} >published</option>
                             <option value="unpublished" {{ $post->status == "unpublished" ? 'selected':""}} >unpublished</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <select name="featured" class="form-control">
                              <option value="1" {{ $post->feature == "1" ? 'selected':""}} >feature</option>
                             <option value="0" {{ $post->feature == "0" ? 'selected':""}} >Do not feature</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
