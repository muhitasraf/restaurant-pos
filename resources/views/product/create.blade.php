@extends('master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header h4">
                {{ $title }}
            </div>
            <div class="card-body">
                <form action="{{ url('/product/store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control form-control-user" name="name"
                                placeholder="Product Name" required="required">
                            <span></span>
                            <label for="description">Description</label>
                            <input type="text" class="form-control form-control-user" name="description" id="description"
                                placeholder="Description">
                            <span></span>
                            <label for="category">Category</label>
                            <select class="form-control" name="category" id="category" required="required">
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span></span>
                            <label for="price">Price</label>
                            <input type="text" class="form-control" name="price" id="price" required="required">
                            <span></span>
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status" required="required">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 my-3 mb-sm-0">
                            <button class="btn btn-success">SAVE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
