@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-10 my-2">
                <a class="btn btn-success" href="{{ url('/sales') }}">
                    <i class="fa fa-money-check-alt" aria-hidden="true"></i> Sales List
                </a>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header h4">
                {{ $title }}
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Customer Name</label>
                            <input class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Customer Code</label>
                            <input class="form-control" value="{{ $customer_code }}" name="customer_code" id="customer_code">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Sale Type <span style="color: red;">*</span></label>
                            <select class="form-control" id="sale_type" name="sale_type" required="required">
                                <option value="">Sale Type</option>
                                <option value="0">Restaurant</option>
                                <option value="1">Online</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group mb-2">
                            <label>Table </label>
                            <select class="form-control" id="table_no" name=table_no>
                                <option value="">Select Table</option>
                                @foreach($tables as $t)
                                    <option value="{{ $t->id }}">{{ $t->table }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="form-group mb-2">
                            <label>Payment Type</label>
                            <select class="form-control select2" id="payment_type" name="payment_type">
                                <option value="">Payment Type</option>
                                <option value="0">Cash</option>
                                <option value="1">Mobile Banking</option>
                                <option value="2">Card</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-striped cart_table">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th class="text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"><b>Total</b></td>
                                            <td><input type="text" style="max-width: 70px;min-width: 70px;" class="form-control total_quantity" id="total_quantity" readonly></td>
                                            <td><input type="text" style="min-width: 130px;" class="form-control grand_total" id="grand_total" readonly></td>
                                        </tr>
                                        <tr>
                                            <td><b>Discount:</b></td>
                                            <td><input type="text" class="form-control discount" id="discount"></td>
                                            <td><b>Vat Amt:</b></td>
                                            <td><input type="text" class="form-control vat" id="vat"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <button type="button" class="btn btn-danger btn-block" onclick="cancleOrder()">
                                    Cancel Order
                                </button>
                                <button type="submit" class="btn btn-success" onclick="saveSaleProduct()">SAVE ORDER</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3">
                            <div class="row col-md-12">
                                <input type="text" class="form-control search_product" placeholder="Search Product...">
                            </div>
                            <div class="row col-md-12 mt-2">
                                @foreach($products as $p)
                                    <div class="col-sm-6 col-md-4" onclick="productAdd('{{ $p->id }}',1)">
                                        <div class="card cart_card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $p->name }}</h5>
                                                <img src="{{asset('global_assets/images/foods.png')}}" height="100px" width="100px" alt="">
                                                <p class="card-text text-center">Tk {{ $p->price }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <style>
        .cart_card:active {
            background-color: #efefef;
            box-shadow: 0 5px #f1efef;
            transform: translateY(4px);
        }
    </style>

<script type="text/javascript">



    var prod_array = [];
    $( document ).ready(function() {
        productFromCart();
    });

    function productAdd(product_id,quantity){
        $.ajax({
            url: "{{ url('/add_to_cart') }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}",product_id:product_id, quantity:quantity},
            dataType: "json",
            success: function (data) {
                productFromCart();
            }
        });
    }

    function deleteProduct(product_id){
        $.ajax({
            url: "{{ url('/delete_from_cart') }}",
            type:'POST',
            data: {_token:"{{csrf_token()}}",product_id:product_id},
            dataType: "json",
            success: function (data) {
                productFromCart();
            }
        });
    }

    function productFromCart(){
        var total_price = 0;
        var total_quantity = 0;
        $.ajax({
            url: "{{ url('/product_from_cart') }}",
            type:'GET',
            data: {_token:"{{csrf_token()}}"},
            dataType: "json",
            success: function (data) {
                var user_cart_table = '';
                for(let i=0; i<data.length;i++){
                    user_cart_table += `<tr>
                                            <td>
                                                <button class="btn btn-danger btn-sm" onclick="deleteProduct(${data[i].id})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>
                                                ${data[i].name}
                                                <input type="hidden" class"product_id" name="product_id[]" value="${data[i].id}">
                                            </td>
                                            <td>
                                                <div style="display: flex;flex-direction: row;">
                                                    <button class="btn btn-success btn-sm" onclick="productAdd(${data[i].id},1)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <input type="text" style="width:50px;" class="form-control form-control-sm quantity" id="quantity" name="quantity[]" value="${data[i].quantity}">

                                                    <button class="btn btn-success btn-sm" onclick="productAdd(${data[i].id},-1)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                ${data[i].quantity*data[i].price}
                                                <input type="hidden" name="total_price[]" value="${data[i].quantity*data[i].price}" id="total_price">
                                            </td>
                                        </tr>`;
                        total_quantity += data[i].quantity;
                        total_price += data[i].price * data[i].quantity;
                }
                $('.cart_table tbody').empty().append(user_cart_table);
                $('.total_quantity').val(total_quantity);
                $('.grand_total').val(total_price);
            }
        });
    }

    function cancleOrder(){
        if (confirm("Cancle this Order!") == true) {
            $.ajax({
                url: "{{ url('/cancle_order') }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}"},
                dataType: "json",
                success: function (data) {
                    productFromCart();
                }
            });
        }
    }

    function saveSaleProduct(){
        var sale_type = $("#sale_type").val();
        var table_no = $("#table_no").val();
        var customer_code = $("#customer_code").val();
        var payment_type = $("#payment_type").val();

        var discount = $("#discount").val();
        var vat = $("#vat").val();
        var total_quantity = $("#total_quantity").val();
        var grand_total = $("#grand_total").val();

        var product_ids = document.getElementsByName('product_id[]');
        var quantity = document.getElementsByName('quantity[]');
        var total_price = document.getElementsByName('total_price[]');

        var product_id_array = [];
        var product_qty_array = [];
        var product_price_array = [];

        for (var i = 0; i < product_ids.length; i++) {
            var prod_id = product_ids[i].value;

            var qty = quantity[i].value;
            qty = (qty != '' ? qty : 0);

            var product_price = total_price[i].value;
            product_price = (product_price != '' ? product_price : 0);

            if(qty > 0){
                product_id_array.push(prod_id);
                product_qty_array.push(qty);
                product_price_array.push(product_price);
            }
        }

        if(sale_type != "" && product_id_array.length > 0){
            $.ajax({
                url: "{{ url('/sales/store') }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", total: total_quantity, discount: discount, vat: vat, grand_total: grand_total, sale_type: sale_type, table_no: table_no, customer_code: customer_code, payment_type: payment_type, product_id_array: product_id_array, product_qty_array: product_qty_array, product_price_array: product_price_array},
                dataType: "json",
                success: function (data) {
                    window.location.href = "{{URL::to('sales')}}"
                }
            });
        }else{
            alert('Please Select All Required Fields!');
        }

    }
</script>

@endsection
