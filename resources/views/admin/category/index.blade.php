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
                                        <i class="fas fa-th-list dark"></i> Categories
                                    </h3>
                                    <a href="{{ url('admin/category/create') }}"class="btn btn-primary">
                                        <i class="fas fa-plus fa-x2"></i>
                                    </a>
                                    <a href="" id="editCompany" data-toggle="modal" data-target='#practice_modal' class="btn btn-primary">
                                        <i class=""></i>Filter
                                    </a>
            </div>

            <div class="modal fade" id="practice_modal" style=" border : 3px solid #ADD8E6">
                        <div class="modal-dialog">
                           <form id="companydata" action="admin/category/search" method="POST" class="form form-inline" style=" border : 3px solid #ADD8E6" role="search">
                             @csrf
                                <div class="modal-content">
                                  <div class="modal-body">
                                      <div class="col-2">
                                         <input type="text" name="title" class="form-control mt-2" placeholder="filter by title">
                                         <input type="text" name="slug" class="form-control mt-2" placeholder="filter by slug">
                                         <button type="submit" class="btn btn-primary mt-2">filter</button>
                                      </div>
                                  </div>
                                </div>
                           </form>
                        </div>
            </div>



            <!-- <form action="/category/search" method="POST" class="form form-inline" role="search">
             @csrf
             <div class="col-2">
                 <input type="text" name="title" class="form-control" placeholder="filter by title">
                 <input type="text" name="slug" class="form-control" placeholder="filter by slug">
                 <button type="submit" class="btn btn-primary">filter</button>
             </div>
            </form> -->
            <table class="table table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->title}}</td>
                            <td>{{ $category->slug}}</td>

                            <td class="d-flex flex-row justify-content-center align-items-center">
                                <a
                                    href="{{ url('admin/category/edit',$category->id) }}"
                                    class="btn btn-sm btn-warning mr-2">
                                        <i class="fa fa-edit"></i>
                                </a>
                                <form id="{{ $category->id }}" method="POST" action="{{ url('admin/category/destroy', $category->id) }}">
                                    @csrf
                                    @method("DELETE")
                                    <button
                                    onclick="event.preventDefault();
                                       if(confirm('Do you really want to delete {{$category->title  }} ?'))
                                        document.getElementById({{ $category->id }}).submit();
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

        </div>
    </div>
</div>

<!-- <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLongTitle">Beneficiary Identification</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
         </button>
        </div>
        <div class="modal-body">
          Image:
           <div class="">
              <img src="" alt="no picture available" width="200" height="200">
           </div>

        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div> -->

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
