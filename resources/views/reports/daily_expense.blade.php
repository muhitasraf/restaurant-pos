@extends('master')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <form action="{{ URL('/daily_expense_result') }}" method="POST">
            @csrf
            <div class="row my-2">
                <div class="col-md-2">
                    <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime(date('Y/m/d'))) }}" name="from_date">
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
                            <th>Expenditures</th>
                            <th>Details</th>
                            <th>Expense</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @if (!empty($daily_expense))
                                @php
                                    $total_expense = 0;
                                @endphp
                                @foreach ($daily_expense as $key=>$expense)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $expense->expenditures }}</td>
                                        <td>{{ $expense->description }}</td>
                                        <td>{{ $expense->date }}</td>
                                        <td>{{ $expense->expense }}</td>
                                    </tr>
                                    @php
                                        $total_expense += $expense->expense;
                                    @endphp
                                @endforeach
                                <tr class="h6">
                                    <td colspan="4">Total</td>
                                    <td>{{ $total_expense }}</td>
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
