<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{


   public function create()
    {
        return view('products.addProduct');
    }

    public function store(Request $request)
    {

       Product::create([
            'title' => $request->product_name,
            'price' => $request->price,
            'inventory' => $request->amount_available,
            'description' => $request->explanation,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->route('products.index');

    }

    public function index()
    {
        $products =Product::get();
        return view('products.productsData', ['products' => $products]);

    }

    public function destroy($id)
    {
       Product::where('id', $id)->update([
            'status' => 'disable'
        ]);
        return back();
    }

    public function edit($id)
    {
        $product =Product::where('id', $id)->first();
        return view('products.editProductMenue', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
     Product::where('id', $id)->update([
            'title' => $request->product_name,
            'price' => $request->price,
            'inventory' => $request->amount_available,
            'description' => $request->explanation,
        ]);
        return redirect()->route('products.index');
    }
}
