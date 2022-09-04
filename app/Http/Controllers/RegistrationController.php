<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller{

    public function save(Request $request){

        if(\Auth::check()){
            return redirect(route('user.lk'));
        }

        $formData = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required'
        ]);

        if(User::where('email',$formData['email'])->exists()){
            return redirect(route('user.registration'))->withErrors([
                'email' => 'user already registered'
            ]);
        }

        $user = User::create($formData);

        if($user){
            auth()->login($user);
            return redirect(route('user.lk'));
        }

        return redirect(route('user.registration'))->withErrors([
            'email' => 'something went wrong...'
        ]);
    }

    public function index() {

        if (\Auth::check()) {
            return redirect(route('user.lk'));
        }

        return view('registration');
    }

}
