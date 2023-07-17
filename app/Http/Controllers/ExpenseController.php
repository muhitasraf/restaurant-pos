<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExpenseController extends Controller
{

    public function index(){
        $title = 'Expenses';
        $expenses = Expense::get();
        return view('expense.index', ['expenses' => $expenses,'title'=>$title]);
    }

    public function create(){
        $title = 'Create Expense';
        return view('expense.create', ['title'=>$title]);
    }

    public function store(Request $request){

        $user_id = auth()->user()->id;

        $result = Expense::create([
            'expenditures' => $request->input('expenditures'),
            'description' => $request->input('description'),
            'date' => date('Y-m-d'),
            'expense' => $request->input('expense'),
            'user_id' => $user_id,
        ]);

        if($result){
            return redirect('/expenses')->with('success','Successfully Created!');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }

    public function edit($id){
        $title = 'Edit Expense';
        $expense_info = Expense::find($id);
        return view('expense.edit', ['title'=>$title, 'expense_info'=>$expense_info]);
    }

    public function update($id, Request $request){

        $expenditures = $request->input('expenditures');
        $description = $request->input('description');
        $expense = $request->input('expense');

        $array = array(
            'expenditures' => $expenditures,
            'description' => $description,
            'expense' => $expense,
        );

        $result = Expense::where('id', $id)->update($array);

        if($result){
            return redirect('/expenses')->with('success','Successfully Updated!');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }

    public function destroy($id){
        $result = Expense::destroy($id);
        if($result){
            return redirect('/expenses')->with('success','Successfully Deleted!');
        }else{
            return redirect()->back()->with('error','Something went wrong!');
        }
    }
}
