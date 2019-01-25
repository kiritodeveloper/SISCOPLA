<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt(['username' => $request['username'], 'password' => $request['password']])){
            if(Auth::user()->active){
                return redirect('inicio');
            }
            else{
                $this->Logout();
            }
        }
        Session::flash('error','error de credenciales, intente de nuevo');
        return redirect()->back();
    }
    public function Logout(){
        Auth::logout();
        return Redirect::to('/');
    }
    public function inicio(){

        return view('login.inicio');
    }
}
