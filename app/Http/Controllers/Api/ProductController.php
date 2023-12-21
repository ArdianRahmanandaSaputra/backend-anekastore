<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(){
        $product = Product::all();
        foreach($product as $p){
            $p->category_name = $p->category->name;
        }

        return response()->json(['product' => $product]);
    }

    public function save(Request $req){
        $product = new Product;
        
        $product->name = $req->name;
        $product->categori_id = $req->categori_id;
        $product->price = $req->price;
        $product->weight = $req->weight;
        $product->stock = $req->stock;
        $product->description = $req->description;

        if($req->hasFile('photo')){
            $validatedData = $req->validate([
                'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            $foto = $req->file('photo')->getClientOriginalName();
            $path = $req->file('photo')->move('uploads/product/' , $foto);
            $product->photo = $foto;
        }

        $product->save();

        return response()->json(['message' => 'product successfully created']);
    }

    public function delete(Request $req){
        $product = Product::findOrFail($req->id);
        if(File::exists(public_path('uploads/product/' . $product->photo))) {
            File::delete(public_path('uploads/product/' . $product->photo));
        }
        Product::destroy($req->id);

        return response()->json(['message' => 'product successfully deleted']);
    }

    public function view($id){
        $product = Product::findOrFail($id);
        $product->category_name = $product->category->name;

        return response()->json(['product' => $product]);
    }

    public function update(Request $req){
        $product = Product::findOrFail($req->id);
        
        $product->name = $req->name;
        $product->categori_id = $req->categori_id;
        $product->price = $req->price;
        $product->weight = $req->weight;
        $product->stock = $req->stock;
        $product->description = $req->description;

        if($req->file('photo')){
            $validatedData = $req->validate([
                'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            if(File::exists(public_path('uploads/product/' . $product->photo))) {
                File::delete(public_path('uploads/product/' . $product->photo));
            }

            $foto = $req->file('photo')->getClientOriginalName();
            $path = $req->file('photo')->move('uploads/product/' , $product->id . $foto);
            $product->photo = $product->id . $foto;
        }
        
        $product->save();

        return response()->json(['message' => 'product successfully updated']);
    }
}
