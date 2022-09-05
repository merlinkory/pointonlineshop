<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;


class ProductController  extends Controller{

    public function getProducts(){
        $products = Product::where('id','>',0)->with('images')->get(); // TODO: change where() to All()

        return response($products, 200)->header('Content-Type', 'application/json');
    }

    public function newProduct(Request $request){

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
