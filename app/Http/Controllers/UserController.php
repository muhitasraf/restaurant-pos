<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function showRegistrationForm(){
        return view('register');
    }

    public function porcessRegistration(Request $request){

        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required',
            'password' => 'required|min:6',
            'cpassword' => 'required|min:6|same:password',
            'image' => 'required|image|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect('register')->withErrors($validator)->withInput();
        }

        $photo = $request->file('photo');
        $filename = uniqid('image_',true).Str::random(10).'.'.$photo->getClientOriginalExtension();
        if($photo->isValid()){
            $photo->move(public_path().'/uploads/images/',$filename);
        }
        $data = [
            'full_name' => $request->input('fullname'),
            'email' => $request->input('email'),
            'contact_number' => $request->input('mobile_number'),
            'address' => $request->input('address'),
            'password' => bcrypt($request->input('password')),
            'image' => $filename,
        ];

        try{
            User::create($data);
            session()->flash('message','Successfully Registered');
            return redirect()->route('login');
        }catch(Exception $e){
            session()->flash('message',$e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function porcessLogin(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $credential = $request->except(['_token']);

        if(auth()->attempt($credential)){
            echo 'Successfully Login';
            session()->flash('message','Successfully Login');
            return redirect()->route('home');
        }else{
            session()->flash('message',"Email or Password doesn't match.");
            return redirect()->back()->withInput();
        }
    }

    public function logout(){
        auth()->logout();
        session()->flash('message','Successfully Login');
        return redirect()->route('login');
    }

    public function profile(){
        return view('profile');
    }
}
