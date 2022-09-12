<?php

namespace App\Http\Controllers;

use http\Client\Response;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\UserPointTransaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {


    public function save(Request $request): \Illuminate\Http\Response{

        //validation
        $validated = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'middleName' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required'
        ]);


        $products = []; //В нее складываем продукты которые есть у нас в корзине (выбранные из БД) и в будующем по тим данным обнавляем данные об остатке товаров в БД

        //check amount of products
        foreach ($request->cart as $productId=>$item){
            $product = Product::find($productId);
            if ($product->quantity < $item['count']){
                $output = [
                    'status'=> 'error',
                    'message'=> "Кол-во {$product->name} не хватает для заказа, максимум {$product->quantity} ше.",
                ];
                return response($output, 200)->header('Content-Type', 'application/json');
            }
            $products[$productId] = $product;
        }

        $cartTotalAmount = $this->getCartTotal($request->cart);

        //Cheking user point balance
        if ($cartTotalAmount > \Auth::user()->balance) {

            $output = [
                'status' => 'error',
                'message' => 'нехватает point на балансе'
            ];
            return response($output, 200);
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
            'owner_id' => \Auth::user()->id,
            'point_value'=> $cartTotalAmount,
            'type'=> 'withdraw',
            'comment' => "order: # {$order->id}"
        ]);

        //Уменькаем кол-во продуктов
        foreach ($request->cart as $productId => $item){

            $product = $products[$productId];
            $product->quantity -= $item['count'];
            $product->save();
        }

        //Уменьщаем баланс пользователя
        $user = User::find(\Auth::user()->id);
        $user->balance -= $cartTotalAmount;
        $user->save();

        DB::commit();

        $output = [
            'status' => 'ok',
             'order' => $order
        ];
        return response($output, 200)->header('Content-Type', 'application/json');

    }

    /**
     * @title Get orders for auth user
     * @return \Illuminate\Http\Response
     */
    public function getUserOrders(): \Illuminate\Http\Response{
        $orders = Order::where('user_id',\Auth::user()->id)->with('OrderItems')->get();
        return response($orders, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request): \Illuminate\Http\Response{
        $orders = Order::with('OrderItems')->paginate(2);
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
