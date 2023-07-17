
<div class="navbar navbar-sm navbar-footer border-top">
    <div class="container-fluid">
        <span>&copy; 2022 <a href="">Limitless Web App Kit</a></span>

        <ul class="nav">
            <li class="nav-item">
                <a href="" class="navbar-nav-link navbar-nav-link-icon rounded">
                    <div class="d-flex align-items-center mx-md-1">
                        <i class="ph-lifebuoy"></i>
                        <span class="d-none d-md-inline-block ms-2">Support</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<script>

    $(document).ready(function() {
        //---------------Initialize Date picker-------------------
        toastr.options = {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if (Session::has('info'))
            toastr.info("{{Session('info')}}");
        @endif

        @if (Session::has('success'))
            toastr.success("{{Session('success')}}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{Session('error')}}");
        @endif

        @if (Session::has('warning'))
            toastr.warning("{{Session('warning')}}");
        @endif

        //---------------Initialize Date picker-------------------
        var startDate = new Date();
        $('.from_month').datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'mm'
        }).on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
            $('.to').datepicker('setStartDate', startDate);
        });

        //-------------Initialize Datatable---------------------
        // $('#dataTable').DataTable();
    });

</script>
