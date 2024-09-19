<?php

namespace App\Http\Controllers\Api;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        if($products->count() > 0)
        {
            return Productresource::collection($products);
        }
        else
        {
            return response()->json(['message'=>'No record avaliable'] ,200);
        }
    }






    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name'=> 'required|string|max:255',
            'description'=>'required',
            'price'=> 'required',

        ]);
        if($validator->fails())
        {

            return response()->json(['message'=> 'all fields are mandatory',
            'error'=> $validator->messages(),
        ], 422);
        }



            $product = Product::create([
                'name'=> $request->name,
                'description'=>$request->description,
                'price'=> $request->price,

            ]);
            return response()->json(['message'=> 'Product created Successfully', 'data'=> new ProductResource ($product)], 200);
    }





    public function show(Product $product)
    {
        return new ProductResource ($product);
    }



    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [

            'name'=> 'required|string|max:255',
            'description'=>'required',
            'price'=> 'required',

        ]);
        if($validator->fails())
        {

            return response()->json(['message'=> 'all fields are mandatory',
            'error'=> $validator->messages(),
        ], 422);
        }



            $product ->update([
                'name'=> $request->name,
                'description'=>$request->description,
                'price'=> $request->price,

            ]);
            return response()->json(['message'=> 'Product updated Successfully', 'data'=> new ProductResource ($product)], 200);
    }




    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message'=> 'Deleted'],200);
    }
}
