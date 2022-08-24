<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController  extends Controller{

    public function getProducts(){
        $products = Product::all()->toArray();
        
        return response($products, 200)->header('Content-Type', 'application/json');
    }
    
    public function newProduct(Request $request){
                
        $product = Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
        ]);
        
         return response($product, 200)->header('Content-Type', 'application/json');
    }
}