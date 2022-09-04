<?php

namespace App\Http\Controllers;

use http\Client\Response;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\UserPointTransaction;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {


    public function saveOrder(Request $request): \Illuminate\Http\Response{

        //validation
        $validated = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'middleName' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required'
        ]);


        $cartTotalAmount = $this->getCartTotal($request->cart);

        //Cheking user point balance
        if ($cartTotalAmount > \Auth::user()->balance) {

            return response('', 402);
        }

        DB::beginTransaction();

        $order = Order::create([
            "user_id" => \Auth::user()->id,
            "first_name" => $request->firstName,
            "last_name" => $request->lastName,
            "middle_name" => $request->middleName,
            "city" => $request->city,
            "address" => $request->address,
             "zip" => $request->zip,
        ]);

        foreach ($request->cart as $item){

            OrderItem::create([
                "order_id" => $order->id,
                "product" => $item['name'],
                "quantity" => $item['count'],
                "price" => $item['price']
            ]);
        }

        UserPointTransaction::create([
            'user_id' => \Auth::user()->id,
            'point_value'=> $cartTotalAmount,
            'type'=> 'withdraw',
            'comment' => "order: # {$order->id}"
        ]);

        $user = User::find(\Auth::user()->id);
        $user->balance -= $cartTotalAmount;
        $user->save();

        DB::commit();

        return response($order, 200)->header('Content-Type', 'application/json');

    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function getOrders(): \Illuminate\Http\Response{
        $orders = Order::where('user_id',\Auth::user()->id)->with('OrderItems')->get();
        return response($orders, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @title Get total point in a cart
     * @param array $cart
     * @return int
     */
    private function getCartTotal(Array $cart): int{
        $amount = 0 ;
        foreach ($cart as $item){
            $amount += $item['count'] * $item['price'];
        }
        return $amount;
    }


}
