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
                                        <i class="fas fa-th-list dark"></i> Products
                                    </h3>
                                    <a href="{{ url('admin/products/create') }}"class="btn btn-primary">
                                        <i class="fas fa-plus fa-x2"></i>
                                    </a>
                                    <a href="" id="editCompany" data-toggle="modal" data-target='#practice_modal' class="btn btn-primary">
                                        <i class=""></i>Filter
                                    </a>
            </div>

            <div class="modal fade" id="practice_modal" style=" border : 3px solid #ADD8E6">
                        <div class="modal-dialog">
                           <form id="companydata" action="/products/search" method="POST" class="form form-inline" style=" border : 3px solid #ADD8E6" role="search">
                             @csrf
                                <div class="modal-content">
                                  <div class="modal-body">
                                      <div class="col-2">
                                         <input type="text" name="title" class="form-control mt-2" placeholder="filter by title">
                                         <input type="text" name="description" class="form-control mt-2" placeholder="filter by description">
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
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>In Stock</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title}}</td>
                            <td>{{ Str::limit($product->description,50) }}</td>
                            <td>{{ $product->inStock }}</td>
                            <td>{{ $product->price }} DH</td>
                            <td>
                                @if($product->inStock > 0)
                                    <i class="fa fa-check text-success"></i>
                                @else
                                    <i class="fa fa-times text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->title }}"
                                    width="50"
                                    height="50"
                                    class="img-fluid rounded"
                                >
                            </td>
                            <td>
                                {{ $product->category->title }}
                            </td>
                            <td class="d-flex flex-row justify-content-center align-items-center">
                                <a
                                    href="{{ url('admin/products/edit',$product->id) }}"
                                    class="btn btn-sm btn-warning mr-2">
                                        <i class="fa fa-edit"></i>
                                </a>
                                <form id="{{ $product->id }}" method="POST" action="{{ url('admin/products/destroy',$product->id) }}">
                                    @csrf
                                    @method("DELETE")
                                    <button
                                    onclick="event.preventDefault();
                                       if(confirm('Do you really want to delete {{ $product->title  }} ?'))
                                        document.getElementById({{ $product->id }}).submit();
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
            <div class="justify-content-center d-flex">
                {{ $products->links() }}
            </div>
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
