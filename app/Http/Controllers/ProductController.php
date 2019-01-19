<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreProduct;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 

        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $categories = Category::all();
        return view('admin.products.create', compact('categories') );
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        //
        // dd($request->all());
        $extension = "." .$request->file('thumbnail')->getClientOriginalExtension();
        $name = basename($request->file('thumbnail')->getClientOriginalName(), $extension ).time();
        $name = $name.$extension;
  
        $path = $request->thumbnail->storeAs('images', $name);

        $product = Product::create([
              "name" => $request->title,
              "slug" =>  $request->slug,
              "descriptions" => $request->description,
              "price" => $request->price,
              "discount_price" => ($request->discount_price) ? $request->discount_price : 0,
              "status" => $request->status, 
              "thumbnail" => $path,
              "featured" => ($request->featured) ? $request->featured : 0,
        ]);

        $product->categories()->attach( $request->category_id ) ;


        if ($product && $product->save() ) {
            return back()->with("message","product added");
        } else {
            return back()->with("message","failed to product added");
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }


}