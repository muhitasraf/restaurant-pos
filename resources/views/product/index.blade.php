@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row my-2">
        <div class="col-sm-4">
            <a class="btn btn-success" href="{{ URL('/product/create') }}">
                <i class="fa fa-plus" aria-hidden="true"></i> Create Product
            </a>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header h4">
            {{ $title }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $k => $p)
                            <tr>
                                <td class="text-center">{{ $k+1 }}</td>
                                <td class="text-center">{{ $p->name }}</td>
                                <td class="text-center">{{ $p->description }}</td>
                                <td class="text-center">{{ $p->category_name }}</td>
                                <td class="text-center">{{ $p->price }}</td>
                                <td class="text-center">{{ ($p->status == 1 ? 'Active' : 'Inactive') }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/product/edit/'.$p->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
