@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include("layouts.sidebar")
        </div>
        <div class="col-md-8">
            <div class="card p-3">
                <h3 class="card-title">Add new Post</h3>
                <div class="card-body">
                    <form method="post" action="{{ url('admin/posts/store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text"
                            name="title"
                            placeholder="title"
                            class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="text"
                            name="excerpt"
                            placeholder="excerpt"
                            class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="file"
                            name="image"
                            class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="text"
                            name="links"
                            placeholder="links"
                            class="form-control">
                        </div>

                        <div class="form-group">
                            <select name="featured" placeholder="Feature this post" >
                               <option value="1">Feature</option>
                               <option value="0">Do not feature yet</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="status" placeholder="status" >
                               <option value="published">published</option>
                               <option value="unpublished">unpublished</option>
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
