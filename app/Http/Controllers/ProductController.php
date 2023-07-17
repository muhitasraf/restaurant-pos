<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDOException;

class ProductController extends Controller
{
    public function index(){
        $title = 'Product List';
        $products = Product::leftJoin('categories', 'categories.id', '=', 'products.category_id')
                    ->select('products.id', 'products.name', 'products.description', 'products.category_id', 'products.price', 'products.status', 'products.user_id', 'categories.name AS category_name')
                    ->get();
        return view('product.index', compact('title','products'));
    }

    public function create(){
        $title = 'Create Product';
        $categories = Category::get();
        return view('product.create', compact('title','categories'));
    }

    public function store(Request $request){
        $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";

        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => array('required','regex:'.$regex),
            'status' => 'required',
        ]);
        $product = new Product();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->user_id = auth()->user()->id;
        $result = $product->save();

        if($result){
            return redirect('/product')->with('success','Successfully Created!');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }

    public function edit($id){
        $title = 'Edit product';
        $product = Product::find($id);
        $categories = Category::get();
        return view('product.edit', compact('title', 'categories', 'product'));
    }

    public function update(Request $request, $id){
        $regex = "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";

        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'price' => array('required','regex:'.$regex),
            'status' => 'required',
        ]);

        $product = Product::find($id);

        try{
            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category;
            $product->price = $request->price;
            $product->status = $request->status;
            $product->save();
            return redirect('/product')->with('success','Successfully Updated!');
        }catch(PDOException $e){
            return redirect()->back()->with('error',"Soething went wrong!");
        }

    }


    public function destroy($id){
        $sales = Product::find($id);
        $result = $sales->delete();
        if($result){
            return redirect('/product')->with('success','Successfully Created!');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }
}
