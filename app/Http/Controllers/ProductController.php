<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController  extends Controller{

    public function get(){
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
            'image_path' => $image_path,  //TODO: change image_path to image
        ]);


         return response($product, 200)->header('Content-Type', 'application/json');
    }

    public function delete(Request $request){

        $product = Product::find($request->id);



        $status = 'ok';
        try{

            //delete product images
            foreach ($product->images as $image){
                Storage::delete('public/images/'. $image->image_path);
            }

           $product->delete();

        }catch (\Exception $ex){
           $status = 'error';
        }

        $output = [
            'status' => $status
        ];

        return response($output, 200)->header('Content-Type', 'application/json');
    }
    public function deleteImage(Request $request){

        $productImage = ProductImage::find($request->id);

        Storage::delete('public/images/'. $productImage->image_path);

        $productImage->delete();

        //TODO: checking answer may be error
        $output = [
            'status'=> 'ok',
        ];

         return response($output, 200)->header('Content-Type', 'application/json');
    }

    public function saveImage(Request $request){

        //TODO: add validation
        $image_path = $request->image->store('public/images');
        $image_path = str_replace("public/images/",'',$image_path);

        $productImage = ProductImage::create([
            'product_id' => $request->product_id,
            'image_path' => $image_path, //TODO: change image_path to image
        ]);

        //TODO: checking answer may be error
        $output = [
            'status' => 'ok',
            'image' => $productImage
        ];

        return response($output, 200)->header('Content-Type', 'application/json');
    }
}
