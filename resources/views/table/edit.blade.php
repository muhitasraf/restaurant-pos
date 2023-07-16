@extends('master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="row my-2">
            <div class="col-sm-2">
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
                            <input type="text" class="form-control form-control-user" name="table" placeholder="Table Name" required="required" value="{{ $table->table }}">
                            <span></span>
                            <button class="btn btn-success my-2">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        function checkEmailAddressAvailability() {
            var email = $("#email_address").val();

            if (email_address != '') {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/user_availability') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        email: email
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            $("#email_emessage").css('display', 'block');
                            $("#email_address").val('');
                            $("#submit_btn").attr('disabled', 'disabled');
                        } else {
                            $("#email_emessage").css('display', 'none');
                            $("#submit_btn").attr('disabled', false);

                            $("#confirm_password").blur();
                        }
                    }
                });
            }
        }
    </script>
@endsection
