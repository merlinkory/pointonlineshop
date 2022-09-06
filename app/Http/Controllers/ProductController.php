<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;


class ProductController  extends Controller{

    public function getProducts(){
        $products = Product::with('images')->get();

        return response($products, 200)->header('Content-Type', 'application/json');
    }

    public function update(Request $request){
       
        $product = Product::find($request->id);

        $product->name =  $request->name;
        $product->description =  $request->description;
        $product->price =  $request->price;
        $product->quantity =  $request->quantity;
        $product->save();

        $output = [
            'status'=> 'ok',
            'product'=> $product,
        ];

        return response($output, 200)->header('Content-Type', 'application/json');

        
    }
    public function save(Request $request){

        //TODO: add checking and validation
        $image_path = $request->image->store('public/images');
        $image_path = str_replace("public/images/",'',$image_path);

        $product = Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "quantity" => $request->quantity,
        ]);

        $productImage = ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $image_path,
        ]);


         return response($product, 200)->header('Content-Type', 'application/json');
    }
}
