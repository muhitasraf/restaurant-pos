<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TableController extends Controller
{
    public function index(){
        $title = 'Tables List';
        $tables = Table::get();
        return view('table.index', ['tables' => $tables, 'title'=>$title]);
    }

    public function create(){
        $title = 'Create Tables';
        return view('table.create', ['title'=>$title]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'table' => 'required',
        ]);

        $table = new Table();
        $table->table = $request->table;
        $table->save();

        Session::put('success_message', 'Successfully Saved!');

        return redirect('tables');
    }

    public function edit($id)
    {
        $title = 'Edit Tables';
        $table = Table::find($id);
        return view('table.edit', ['table' => $table, 'title'=>$title]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'table' => 'required',
        ]);

        $table = Table::find($id);
        $table->table = $request->table;
        $table->save();

        Session::put('success_message', 'Successfully Updated!');

        return redirect('tables');
    }

    public function destroy($id){
        $res = Table::destroy($id);
        Session::put('success_message', 'Successfully Deleted!');
        return redirect('tables');
    }
}
