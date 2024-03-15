<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Discount;
use File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(){
        $product = Product::paginate(5);
        foreach($product as $p){
            $p->category_name = $p->category->name;
        }

        return response()->json(['product' => $product]);
    }

    public function getProduct(){
        $product = Product::all();
        $orderDetail = OrderDetail::all();

        foreach($product as &$p){
            $p->category_name = $p->category->name;
            $p->terjual = 0;
            foreach($orderDetail as $od){
                if($od->product_id == $p->id){
                    $p->terjual += intval($od->amount);
                }
            }
        }

        return response()->json(['product' => $product]);
    }

    public function save(Request $req){
        $disc = json_decode($req->discount);
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

        // $constraintDiscount = json_decode($req->input('constraintDiscount'));
        // $discount = json_decode($req->input('discount'));
        // $discountDescription = json_decode($req->input('discountDescription'));

        // Loop dan simpan data seperti yang Anda lakukan sebelumnya
        foreach ($disc as $index => $data) {
            $disc = new Discount;
            $disc->product_id = $product->id;
            $disc->constraint = $data->constraint;
            $disc->discounts = $data->discount;
            $disc->description = $data->description; 

            $disc->save();
        }

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
        $product = Product::with('discounts')->findOrFail($id);
        $product->category_name = $product->category->name;

        return response()->json(['product' => $product]);
    }

    public function getproductbycategory(Request $req){
        $product = Product::where('categori_id', $req->id)->get();

        return response()->json(['product' => $product]);
    }

    public function update(Request $req){
        $disc = json_decode($req->discount);
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

        $discounts = Discount::where('product_id', $product->id)->delete();
        
        foreach ($disc as $index => $data) {
            $disc = new Discount;
            $disc->product_id = $product->id;
            $disc->constraint = $data->constraint;
            $disc->discounts = $data->discount;
            $disc->description = $data->description; 

            $disc->save();
        }


        return response()->json(['message' => 'product successfully updated']);
    }

    public function relatedproduct(Request $req){
        $product = Product::findOrFail($req->id);
        $relatedProduct = Product::where('categori_id', $product->categori_id)->get();
        
        
        return response()->json(['relatedProduct' => $relatedProduct]);
    }
}
