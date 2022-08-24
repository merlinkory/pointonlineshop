<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller {
    
    public function login(Request $request){
        
        // Если уже авторизован
        if(\Auth::check()){
            return redirect('/lk');
        }
        
        $formData = $request->only(['email','password']);
               
        $user = User::where('email',$formData['email'])->where('password',$formData['password'])->get()->first();
        
        if($user){
            auth()->login($user);
            
            return redirect(route('user.lk'));
        }
        
        return redirect('/login')->withErrors([
            'email' => 'auth fail'
        ]);
    }
    
    public function index() {
        if (\Auth::check()) {
            return redirect(route('user.lk'));
        }

        return view('login');
    }
    
    public function logout() {
        \Auth::logout();
        return redirect(route('user.login'));
    }

}
