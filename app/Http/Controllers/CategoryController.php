<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(){
        $title = 'Category List';
        $categories = Category::get();
        return view('category.index', compact('title','categories'));
    }

    public function create(){
        $title = 'Create Category';
        return view('category.create', compact('title'));
    }

    public function store(Request $request){

        $category = new Category();

        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->user_id = auth()->user()->id;
        $result = $category->save();

        if($result){
            return redirect('/categories')->with('success','Successfully Saved!');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }

    public function edit($id){
        $title = 'Edit Category';
        $category_info = Category::find($id);
        return view('category.edit', compact('category_info', 'title'));
    }

    public function update(Request $request, $id){
        $category = Category::find($id);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        $result = $category->save();

        if($result){
            return redirect('/categories')->with('success','Successfully Updated!');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }


    public function destroy($id){
        $sales = Category::find($id);
        $result = $sales->delete();

        if($result){
            return redirect('/categories')->with('success','Successfully Deleted!');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }
}
