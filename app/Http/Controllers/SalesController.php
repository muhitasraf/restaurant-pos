<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SalesController extends Controller
{
    public function index(){
        $title = 'Pending Sale List';

        $u_id = 0;
        $user_id = 1;//auth()->user()->id;
        $parent_id = 1;//auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $pending_list_query = DB::table('sales_summary')
                        ->leftJoin('customers', 'sales_summary.customer_id', '=', 'customers.id')
                        ->leftJoin('tables', 'sales_summary.table_id', '=', 'tables.id')
                        ->select('sales_summary.*', 'customers.customer_code', 'tables.table')
                        ->where('sales_summary.status', '=', 0)
                        ->where('sales_summary.user_id', '=', $u_id);

        // switch (auth()->user()->access_level) {
        //     case 1:
        //         $pending_list_query->where('sales_summary.user_id', '=', $u_id);
        //         break;
        //     case 2:
        //         $pending_list_query->where('sales_summary.sold_by', '=', $user_id);
        //         break;
        //     }

        $pending_list = $pending_list_query->get();

        return view('sales.index', ['title'=>$title, 'pending_list'=>$pending_list]);
    }

    public function create(){
        $title = 'Sale Product';

        $customer_code = '';
        $random_str = strtoupper(Str::random(5));

        $prev_customer_code = DB::table('customers')->select('id','customer_code')->orderBy('id','DESC')->first();

        if(!empty($prev_customer_code->customer_code)){
            // $prev_customer_code_str = substr($prev_customer_code->customer_code,0,5);
            $prev_customer_code_num = substr($prev_customer_code->customer_code,6,strlen($prev_customer_code->customer_code));
            $customer_code = $random_str.sprintf('%08d', $prev_customer_code_num + 1);
        }else{
            $customer_code = $random_str."00000000";
        }

        $products = Product::where('status', 1)->get();
        $tables = Table::get();

        return view('sales.create', ['products' => $products, 'tables' => $tables, 'title'=>$title, 'customer_code'=> $customer_code]);
    }

    public function store(Request $request){

        $u_id = 0;
        $user_id = 1;//auth()->user()->id;
        $parent_id = 1;//auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $sale_type = $request->sale_type;
        $sell_date = date('Y-m-d');
        $table_no = $request->table_no;
        $customer_code = $request->customer_code;
        $payment_type = $request->payment_type;
        $total = $request->total;
        $discount = $request->discount;
        $vat = $request->vat;
        $grand_total = $request->grand_total;

        $product_id_array = $request->product_id_array;
        $product_qty_array = $request->product_qty_array;
        $product_price_array = $request->product_price_array;

        $customer_id = 0;

        if($customer_code != ''){
            $customer_info = Customer::where('customer_code', '=', $customer_code)->get();
            $customers_count = $customer_info->count();

            if($customers_count == 0){
                $customer = new Customer();
                $customer->customer_code = $customer_code;
                $customer->user_id = $u_id;
                $customer->save();

                $customer_id = $customer->id;
            }else{
                $customer_id = $customer_info[0]->id;
            }
        }

        $invoice_no = $u_id.$user_id.date('YmdHis');

        $invoice_id = DB::table('sales_summary')->insertGetId([
                        'invoice_no' => $invoice_no,
                        'customer_id' => $customer_id,
                        'total_quantity' => $total,
                        'discount_percentage' => $discount,
                        'vat_percentage' => $vat,
                        'grand_total' => $grand_total,
                        'table_id' => $table_no,
                        'sold_by' => $user_id,
                        'user_id' => $u_id,
                        'sell_type' => $sale_type,
                        'payment_type' => $payment_type,
                        'sell_date' => date('Y-m-d'),
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

        foreach($product_id_array as $k => $v){

            $data = array(
                'invoice_id' => $invoice_id,
                'product_id' => $v,
                'quantity' => $product_qty_array[$k],
                'price' => $product_price_array[$k],
                'sell_date' => $sell_date,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            DB::table('sales')->insert($data);

        }

        DB::table('user_carts')->where('user_id','=',$user_id)->delete();

        return response()->json($invoice_id);
    }

    public function printOrder($invoice_id){
        $title = 'Print Order';

        $order_info = Sales::find($invoice_id);
        $invoice_no = $order_info->invoice_no;

        $order_list = DB::select(
            DB::raw("SELECT t2.name AS product_name, t1.invoice_id, t1.product_id,
                    t1.quantity FROM `sales_detail` AS t1
                    LEFT JOIN
                    products AS t2
                    ON t1.product_id=t2.id
                    WHERE t1.invoice_id=$invoice_id"));

        return view('print_order_list', ['invoice_no' => $invoice_no, 'order_list' => $order_list, 'title' => $title]);
    }

    public function printInvoice($invoice_id){
        $title = "Invoice Print";

        $user_id = auth()->user()->id;
        $user_info = User::find($user_id);

        $order_summary = Sales::find($invoice_id);

        if($order_summary->status == 1){
            echo '<div style="text-align: center;">';
            echo '<h1 style="background-color: green; color: white;">Already Sold!<h1>';
            echo '<h2 style="background-color: yellow;">Please contact with admin to reprint Invoice.</h2>';
            echo '</div>';
        }elseif($order_summary->status == 2){
            echo '<div style="text-align: center;">';
            echo '<h1 style="background-color: red; color: white;">Already Cancelled!<h1>';
            echo '<h2 style="background-color: yellow;">Please contact with admin to reprint Invoice.</h2>';
            echo '</div>';
        }else{

            $order_summary->status = 1;
            $order_summary->save();

            $order_list = DB::select(
                DB::raw("SELECT t2.name AS product_name, t1.invoice_id, t1.product_id,
                        t1.quantity, t1.price FROM `sales_detail` AS t1
                        LEFT JOIN
                        products AS t2
                        ON t1.product_id=t2.id
                        WHERE t1.invoice_id=$invoice_id"));

            return view('print_order_invoice', ['user_info' => $user_info, 'order_summary' => $order_summary, 'order_list' => $order_list, 'title' => $title]);
        }
    }

    public function editOrder($invoice_id){
        $title = 'Edit Order';

        $u_id = 0;
        $user_id = auth()->user()->id;
        $parent_id = auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $tables = Table::where('user_id', '=', $u_id)->get();

        $sales_summary = Sales::find($invoice_id);

        if($sales_summary->status == 0){

            $customer_info = Customer::find($sales_summary->customer_id);

            $sales_detail = DB::select("SELECT t2.name AS product_name, t1.invoice_id, t1.product_id,
                                    t1.quantity, t1.price FROM `sales_detail` AS t1
                                    LEFT JOIN
                                    products AS t2
                                    ON t1.product_id=t2.id
                                    WHERE t1.invoice_id=$invoice_id");

            $prod_array = [];

            foreach($sales_detail as $sd){
                array_push($prod_array, $sd->product_id);
            }

            $products = Product::where('user_id', '=', $u_id)
                        ->whereNotIn('id', $prod_array)
                        ->where('status', 1)
                        ->get();

            return view('edit_sale_product', ['products' => $products, 'tables' => $tables, 'sales_summary'=>$sales_summary, 'sales_detail'=>$sales_detail, 'customer_info'=>$customer_info, 'title' => $title]);

        }elseif($sales_summary->status == 1){
            echo '<div style="text-align: center;">';
            echo '<h1 style="background-color: green; color: white;">Already Sold!<h1>';
            echo '<h2 style="background-color: yellow;">Please contact with admin to reprint Invoice.</h2>';
            echo '</div>';
        }else{
            echo '<div style="text-align: center;">';
            echo '<h1 style="background-color: red; color: white;">Already Cancelled!<h1>';
            echo '<h2 style="background-color: yellow;">Please contact with admin to reprint Invoice.</h2>';
            echo '</div>';
        }

    }

    public function udpateSaleProduct(Request $request){

        $u_id = 0;
        $user_id = auth()->user()->id;
        $parent_id = auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $invoice_id = $request->invoice_id;
        $sale_type = $request->sale_type;
        $table_no = $request->table_no;
        $customer_code = $request->customer_code;
        $payment_type = $request->payment_type;
        $total = $request->total;
        $discount = $request->discount;
        $vat = $request->vat;
        $grand_total = $request->grand_total;

        $product_id_array = $request->product_id_array;
        $product_qty_array = $request->product_qty_array;
        $product_price_array = $request->product_price_array;

        $customer_id = 0;

        if($customer_code != ''){
            $customer_info = Customer::where('customer_code', '=', $customer_code)->get();
            $customers_count = $customer_info->count();

            if($customers_count == 0){
                $customer = new Customer();
                $customer->customer_code = $customer_code;
                $customer->user_id = $u_id;
                $customer->save();

                $customer_id = $customer->id;
            }else{
                $customer_id = $customer_info[0]->id;
            }
        }

        $affected = DB::table('sales_summary')
                    ->where('id', $invoice_id)
                    ->update([
                        'customer_id' => $customer_id,
                        'total_amount' => $total,
                        'discount_percentage' => $discount,
                        'vat_percentage' => $vat,
                        'grand_total' => $grand_total,
                        'table_id' => $table_no,
                        'sold_by' => $user_id,
                        'user_id' => $u_id,
                        'sell_type' => $sale_type,
                        'payment_type' => $payment_type,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

        DB::table('sales_detail')->where('invoice_id', '=', $invoice_id)->delete();

        foreach($product_id_array as $k => $v){

            $data = array(
                'invoice_id' => $invoice_id,
                'product_id' => $v,
                'quantity' => $product_qty_array[$k],
                'price' => $product_price_array[$k],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            DB::table('sales_detail')->insert($data);

        }

        return response()->json($invoice_id);
    }

    public function product_from_cart(){
        $user_id = 1;//auth()->user()->id;
        $user_cart = DB::table('user_carts')->leftJoin('products','user_carts.product_id','=','products.id')->where('user_carts.user_id',$user_id)->get();
        return response()->json($user_cart);
    }

    public function add_to_cart(Request $request){
        $user_id = 1;//auth()->user()->id;
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $user_cart = DB::table('user_carts')->where('product_id',$product_id)->first();
        $result = '';
        if(!empty($user_cart)){
            $quantity = $user_cart->quantity + $quantity;
            if($quantity>0){
                DB::table('user_carts')->where('user_id','=',$user_id)->where('product_id','=',$product_id)->update(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
                $result = ['status'=>200,'message'=>'Successfully Updated.'];
            }else{
                $result = ['status'=>201,'message'=>'Quantity Can\'t be less then or equal to 0.'];
            }

        }else{
            DB::table('user_carts')->where('user_id','=',$user_id)->insert(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
            $result = ['status'=>200,'message'=>'Successfully Added.'];
        }
        return response()->json($result);
    }

    public function delete_from_cart(Request $request){
        $user_id = 1;//auth()->user()->id;
        $product_id = $request->product_id;
        DB::table('user_carts')->where('user_id','=',$user_id)->where('product_id','=',$product_id)->delete();
        return response()->json('ok');
    }

    public function cancle_order(Request $request){
        $user_id = 1;//auth()->user()->id;
        DB::table('user_carts')->where('user_id','=',$user_id)->delete();
        return response()->json('ok');
    }
}
