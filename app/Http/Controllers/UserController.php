<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPointTransaction;
class UserController  extends Controller{

    public function getUsers(){
       $users =  User::All()->toArray();
       return response($users, 200)->header('Content-Type', 'application/json');       
    }
    
    public function makeUserPointTransaction(Request $request){                
        
        $user_point_transaction = UserPointTransaction::create([
            'user_id' => $request->user_id,
            'owner_id' => \Auth::user()->id,
            'point_value' => $request->user_point,
            'type' => 'deposit',
            'comment' => 'test'
        ]);
        
        $user = User::find($request->user_id);
        $user->balance += $request->user_point;
        $user->save();
        
        return response($user_point_transaction, 200)->header('Content-Type', 'application/json');
    }
}
