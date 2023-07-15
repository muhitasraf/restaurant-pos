@php
    use Illuminate\Support\Facades\Session;
@endphp

@extends('master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row my-2">
            <div class="col-sm-2">
                <a class="btn btn-success" href="{{ URL('/categories') }}">
                    <i class="fa fa-list" aria-hidden="true"></i> Category
                </a>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header h4">
                {{ $title }}
            </div>
            <div class="card-body">
                <form action="{{ url('/category/update/'.$category_info->id) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control form-control-user" name="name" value="{{ $category_info->name }}" placeholder="Category Name" required="required">
                            <span> </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="description">Description</label>
                            <input type="text" class="form-control form-control-user" name="description" value="{{ $category_info->description }}" id="description" placeholder="Description">
                            <span> </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <label for="status">Select Status</label>
                            <select class="form-control" name="status" id="status" required="required">
                                <option value="">Select Status</option>
                                <option value="1" @if ($category_info->status == 1) selected="selected" @endif>Active</option>
                                <option value="0" @if ($category_info->status == 0) selected="selected" @endif>Inactive</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-sm-6 mt-2">
                        <button class="btn btn-success">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
