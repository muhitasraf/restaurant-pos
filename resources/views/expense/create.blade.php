@extends('master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <a class="btn btn-success my-2" href="{{ URL('expenses') }}">
            <i class="fa fa-list" aria-hidden="true"></i>Expenses
        </a>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header h4">
                {{ $title }}
            </div>
            <div class="card-body">
                <form action="{{ url('/expense/store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                                <label for="expenditures">Expenditures</label>
                                <input type="text" class="form-control form-control-user" name="expenditures"
                                    placeholder="Expenditures" required="required">
                                <span></span>
                                <label for="description">Description</label>
                                <input type="text" class="form-control form-control-user" name="description" id="description" placeholder="Description">
                                <span></span>
                                <label for="">Expense Amount</label>
                                <input type="number" class="form-control form-control-user" name="expense" id="expense"
                                    placeholder="Expense Amount" required="required">
                                <span></span>
                                <button class="btn btn-success my-2">SAVE</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
