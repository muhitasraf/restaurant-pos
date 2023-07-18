@extends('master')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <form action="{{ URL('/monthly_sales_result') }}" method="POST">
            @csrf
            <div class="row my-2">
                <div class="col-md-2">
                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('last month')) }}" name="from_date">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime(date('Y/m/d'))) }}" name="to_date">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-info">Search</button>
                </div>
            </div>
        </form>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header h4">
                {{ $title }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th>SN</th>
                            <th>Product Nmae</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </thead>
                        <tbody>
                            @if (!empty($monthly_sales))
                                @php
                                    $total_quantity = 0;
                                    $total_price = 0;
                                @endphp
                                @foreach ($monthly_sales as $key=>$sales)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $sales->product_name }}</td>
                                        <td>{{ $sales->quantity }}</td>
                                        <td>{{ $sales->price }}</td>
                                    </tr>
                                    @php
                                        $total_quantity += $sales->quantity;
                                        $total_price += $sales->price;
                                    @endphp
                                @endforeach
                                <tr class="h6">
                                    <td>Total</td>
                                    <td></td>
                                    <td>{{ $total_quantity }}</td>
                                    <td>{{ $total_price }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="4">There is no data!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
