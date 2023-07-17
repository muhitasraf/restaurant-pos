@extends('master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-sm-10 my-2">
                <a class="btn btn-success" href="{{ url('/sales/create') }}">
                    <i class="fa fa-plus" aria-hidden="true"></i> Sale Product
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
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Table</th>
                                <th class="text-center">Customer ID</th>
                                <th class="text-center">Sale Type</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pending_list as $k => $pl)
                                <tr>
                                    <td class="text-center">{{ $k + 1 }}</td>
                                    <td class="text-center">{{ $pl->invoice_no }}</td>
                                    <td class="text-center">{{ $pl->table }}</td>
                                    <td class="text-center">{{ $pl->customer_code }}</td>
                                    <td class="text-center">{{ $pl->sell_type == 0 ? 'Restaurant' : 'Online' }}</td>
                                    <td class="text-center">{{ $pl->grand_total }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('/sales/edit/' . $pl->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ url('/print/' . $pl->id) }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fa fa-print"></i> Print
                                        </a>
                                        <a href="{{ url('/print_invoice/' . $pl->id) }}" target="_blank" class="btn btn-sm btn-warning"
                                            onclick="return confirm('Are you sure to print invoice?');">
                                            <i class="fa fa-receipt"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        function invoiceConfirmation(id) {
            var c = confirm('Are you sure to print invoice?');

            if (c == true) {
                window.open("{{ url('/print_invoice/"+id+"') }}", '_blank');
                location.reload();
            }
        }
    </script>
@endsection
