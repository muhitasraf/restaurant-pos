@extends('master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <a class="btn btn-success my-2" href="{{ URL('/tables') }}">
            <i class="fa fa-list" aria-hidden="true"></i> Table
        </a>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header h4">
                {{ $title }}
            </div>
            <div class="card-body">
                <form action="{{ URL('/table/store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-5 mb-3 mb-sm-0">
                            <label for="table">Table Name</label>
                            <input type="text" class="form-control form-control-user" name="table"
                                placeholder="Table Name" required="required">
                            <span></span>
                            <button class="btn btn-success my-2">SAVE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
