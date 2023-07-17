@extends('master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row my-2">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <a class="btn btn-success" href="{{ URL('/tables') }}">
                    <i class="fa fa-list" aria-hidden="true"></i> Table List
                </a>
                <a class="btn btn-success" href="{{ URL('/table/create') }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> Create Table
                </a>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header h3">
                {{ $title }}
            </div>
            <div class="card-body">
                <form action="{{ URL('/table/update/' . $table->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="table">Table Name</label>
                            <input type="text" class="form-control form-control-user" name="table"
                                placeholder="Table Name" required="required" value="{{ $table->table }}">
                            <span></span>
                            <button class="btn btn-success my-2">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    
@endsection
