<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    use AuthorizesRequests;


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


    Log::info('CREATIOM OF PRODUCT BY  USER EMAIL '.auth()->user()->email . ' WITH ID '. $request->user()->id ) ;

  try{   $validated = $request->validate(['name'=>'required|string|max:255',
        'price'=>'required | numeric | min:0',
        'description'=>'nullable | string'
]);

    $product =  Product::create(['name'=>$validated['name'],'price'=>$validated['price'],'description'=>$validated['description'],'user_id'=>$request->user()->id]);


    /* return redirect()->route('products.index'); */

    /* return response()->json($product,201); */

    return response(['message'=>'Product Created ','data'=>$product],201); }catch(\Exception $e){

        Log::error("ERROR AA GYA ".$e->getMessage());

        return response(['message'=>$e->getMessage()],401);

        }



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


       try{


        Log::info(" USER ID === PRODUCT USER ID". $request->user()->id===$product->user_id );

         $this->authorize('update',$product);


        $request->validate(['name'=>'required|string|max:255','price'=>'required| numeric | min:0']);

        $product->update($request->only(['name','price']));

        return response()->json(['message'=>'product is updated','data'=>$product]); }catch(\Exception $e){

            Log::error('UPDATE ERROR FROM USER  '. auth()->user()->email . '   WITH ROLE AS '. auth()->user()->role .  ' ERROR IS '. $e->getMessage() );

        }




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Product $product)
    {


      try{   $this->authorize('delete',$product);
        $product->delete();
        return response()->json(['message'=>'Product Deleted Successfully']); }

    catch(\Exception $e){


            Log::error('DELETE ERROR FROM USER  '. auth()->user()->email . '   WITH ROLE AS '. auth()->user()->role .  ' ERROR IS '. $e->getMessage() );


    }


}

}
