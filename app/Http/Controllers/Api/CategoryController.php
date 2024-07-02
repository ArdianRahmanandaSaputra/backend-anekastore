<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use File;

class CategoryController extends Controller
{
    public function index(){
        $category = Category::all();

        return response()->json(['category' => $category]);
    }

    public function save(Request $req){
        $category = new Category;

        $category->name = $req->name;
        $category->description = $req->description;
        if($req->hasFile('photo')){
            $validatedData = $req->validate([
                'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            $foto = $req->file('photo')->getClientOriginalName();
            $path = $req->file('photo')->move('uploads/category/' , $foto);
            $category->photo = $foto;
        }

        $category->save();

        return response()->json(['message' => 'category successfully created']);
    }

    // public function delete(Request $req){
    //     $category = Category::findOrFail($req->id);
    //     if(File::exists(public_path('uploads/category/' . $category->photo))) {
    //         File::delete(public_path('uploads/category/' . $category->photo));
    //     }
    //     Category::destroy($req->id);

    //     return response()->json(['message' => 'category successfully deleted']);
    // }

   public function delete(Request $req){
    // Temukan kategori yang akan dihapus
    $category = Category::findOrFail($req->id);

    // Ambil semua produk yang memiliki category_id yang sesuai dengan id kategori yang akan dihapus
    $products = Product::where('categori_id', $category->id)->get();

    // Hapus setiap produk yang terkait dengan kategori tersebut
    foreach ($products as $product) {
        if(File::exists(public_path('uploads/products/' . $product->photo))) {
            File::delete(public_path('uploads/products/' . $product->photo));
        }
        // Hapus produk
        $product->delete();
    }

    // Setelah semua produk yang terkait telah dihapus, baru hapus kategori itu sendiri
    if(File::exists(public_path('uploads/category/' . $category->photo))) {
        File::delete(public_path('uploads/category/' . $category->photo));
    }
    Category::destroy($req->id);

    return response()->json(['message' => 'Category and related products successfully deleted']);
    }


    public function view($id){
        $category = Category::findOrFail($id);

        return response()->json(['category' => $category]);
    }

    public function update(Request $req){
        $category = Category::findOrFail($req->id);

        $category->name = $req->name;
        $category->description = $req->description;

        if($req->file('photo')){
            $validatedData = $req->validate([
                'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            if(File::exists(public_path('uploads/category/' . $category->photo))) {
                File::delete(public_path('uploads/category/' . $category->photo));
            }

            $foto = $req->file('photo')->getClientOriginalName();
            $path = $req->file('photo')->move('uploads/category/' , $category->id . $foto);
            $category->photo = $category->id . $foto;
        }

        $category->save();

        return response()->json(['message' => 'category successfully updated']);
    }
}
