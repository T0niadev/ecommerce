@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-8">
            <div class="d-flex flex-row justify-content-between align-items-center border-bottom pb-1">
                                    <h3 class="text-secondary">
                                        <i class="fas fa-th-list dark"></i> Posts
                                    </h3>
                                    <a href="{{ url('admin/posts/create') }}"class="btn btn-primary">
                                        <i class="fas fa-plus fa-x2"></i>
                                    </a>
                                    <a href="" id="editCompany" data-toggle="modal" data-target='#practice_modal' class="btn btn-primary">
                                        <i class=""></i>Filter
                                    </a>
            </div>

            <div class="modal fade" id="practice_modal" style=" border : 3px solid #ADD8E6">
                        <div class="modal-dialog">
                           <form id="companydata" action="admin/products/search" method="POST" class="form form-inline" style=" border : 3px solid #ADD8E6" role="search">
                             @csrf
                                <div class="modal-content">
                                  <div class="modal-body">
                                      <div class="col-2">
                                         <input type="text" name="title" class="form-control mt-2" placeholder="filter by title">
                                         <input type="text" name="excerpt" class="form-control mt-2" placeholder="filter by description">
                                         <button type="submit" class="btn btn-primary mt-2">filter</button>
                                      </div>
                                  </div>
                                </div>
                           </form>
                        </div>
            </div>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Excerpt</th>
                        <th>Image</th>
                        <th>Links</th>
                        <th>Featured</th>
                        <!-- <th>P</th>
                        <th>In Stock</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th></th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($post as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title}}</td>
                            <td>{{Str::words($post->excerpt,10)}}</td>
                            <td>
                                <img src="{{ asset($post->image) }}"
                                     alt=""
                                    width="50"
                                    height="50"
                                    class="img-fluid rounded"
                                >
                            </td>
                            <td>{{ $post->links }}</td>
                            <td>{{ $post->featured }}</td>
                            <td class="d-flex flex-row justify-content-center align-items-center">
                                <a
                                    href="{{ url('admin/posts/edit', $post->id) }}"
                                    class="btn btn-sm btn-warning mr-2">
                                        <i class="fa fa-edit"></i>
                                </a>
                                <form id="{{ $post->id }}" method="POST" action="{{ url('admin/post/destroy',$post->id) }}">
                                    @csrf
                                    @method("DELETE")
                                    <button
                                    onclick="event.preventDefault();
                                       if(confirm('Do you really want to delete {{ $post->title  }} ?'))
                                        document.getElementById({{ $post->id }}).submit();
                                    "
                                    class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
        </div>
    </div>
</div>
@endsection

<script>
$(document).ready(function () {

$('body').on('click', '#editCompany', function (event) {

    event.preventDefault();
    var id = $(this).data('id');
    $.get('color/' + id + '/edit', function (data) {
         $('#userCrudModal').html("Edit category");
         $('#submit').val("Edit category");
         $('#practice_modal').modal('show');
         $('#color_id').val(data.data.id);
         $('#name').val(data.data.name);
     })
});

});
</script>
