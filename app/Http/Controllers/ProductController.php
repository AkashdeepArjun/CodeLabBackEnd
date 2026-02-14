<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $products = Product::query()
        ->when($request->filled('search'),function ($q) use ($request) {
        $q->where('name','like','%'.$request->search . '%');})

        ->when($request->filled('min_price'),function($q)use ($request){

        $q->where('price','>=',$request->min_price);

            })

         ->when($request->filled('max_price'),function($q)use ($request){

        $q->where('price','<=',$request->max_price);

        })

        ->when($request->sort_by,function ($q) use ($request){

        $direction = $request->dir??'desc';
        $q->orderBy($request->sort_by,$direction);

})
        ->latest()
        ->paginate(5);

        return response()->json($products);

}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    $validated = $request->validate(['name'=>'required|string|max:255',
        'price'=>'required | numeric | min:0',
        'description'=>'nullable | string'

]);

    $product =  Product::create($validated);


    /* return redirect()->route('products.index'); */

    /* return response()->json($product,201); */

    return response(['message'=>'Product Created ','data'=>$product],201);



    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
