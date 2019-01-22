<?php
namespace App\Http\Controllers;
use App\Category;
use App\Http\Requests\StoreProduct;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class ProductController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
$products = Product::latest()->get();
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


// get the immge
$image = $request->file('thumbnail');
// check if diir exist where our product would uplooaded

if ($image) {
$current_date = Carbon::now()->toDateString();
$file_name = $current_date.uniqid().$image->getClientOriginalName();
// if  dir not exist
if (!Storage::disk('public')->exists('products') ) {
// then make tthe dir
Storage::disk('public')->makeDirectory('products');
}
// if dirr eexist
if (Storage::disk('public')->exists('products') ) {

// resize the image
$product_image = Image::make($image)->resize(300, 200)->save();

// now save the image;
Storage::disk('public')->put('products/'.$file_name, $product_image);
$product = Product::create([
"name" => $request->title,
"slug" =>  $request->slug,
"descriptions" => $request->description,
"price" => $request->price,
"discount_price" => ($request->discount_price) ? $request->discount_price : 0,
"status" => $request->status,
"thumbnail" => $file_name,
"featured" => ($request->featured) ? $request->featured : 0,
]);

if ($product  ) {

$product->categories()->attach( $request->category_id ) ;
$product->save();
return back()->with("message","product added");
} else {
return back()->with("message","failed to product added");

}
}
} else {
echo 'noimage.jpeg';
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

$categories = Category::all();
$products = Product::all();
return view('admin.products.edit', compact('products','product','categories') );
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  \App\Product  $product
* @return \Illuminate\Http\Response
*/
public function update(StoreProduct $request, Product $product)
{
//
// dd($request->all());
// check if diir exist where our product would uplooaded

if ($request->has('thumbnail')) {
$current_date = Carbon::now()->toDateString();
$file_name = $current_date.uniqid().$request->file('thumbnail')->getClientOriginalName();
// if  dir not exist
if (!Storage::disk('public')->exists('products') ) {
// then make tthe dir
Storage::disk('public')->makeDirectory('products');
}
// delete the previous photograph
if (Storage::disk('public')->exists('products/'. $product->thumbnail) ) {
Storage::disk('public')->delete('products/'. $product->thumbnail );
}
// if dirr eexist
if (Storage::disk('public')->exists('products') ) {

// resize the image
$product_image = Image::make($request->thumbnail)->resize(300, 200)->save();

// now save the image;
Storage::disk('public')->put('products/'.$file_name, $product_image);
$product->thumbnail= $file_name;
}
}

// finnaly save the new record

$product->name= $request->title;
$product->slug = $request->slug;
$product->descriptions= $request->description;
$product->price = $request->price;
$product->discount_price = ($request->discount_price) ? $request->discount_price : 0;
$product->status = $request->status;
$product->featured = ($request->featured) ? $request->featured : 0;

// deattact the prooduct category
$product->categories()->sync( $request->category_id ) ;

if ($product  ) {

$product->categories()->sync( $request->category_id ) ;
$product->save();
// return back()->with("message","product updated successfully");
return redirect('admin/product')->with("message","product updated successfully");
} else {
return back()->with("message","failed to product update try again");

}
}
/**
* Remove the specified resource from storage.
*
* @param  \App\Product  $product
* @return \Illuminate\Http\Response
*/



public function destroy(Product $product)
{

 // delete the record with photto
    if (Storage::disk('public')->exists('products/'. $product->thumbnail) ) {
        Storage::disk('public')->delete('products/'. $product->thumbnail );
    }

    if ($product->forceDelete() && $product->categories()->detach() ) {

    return back()->with("message","product deleted");
    } else {

    return back()->with("message","failed to delete product");
    }


}







public function remove(Product  $product)
{

        if ($product->delete()) {

        return back()->with("message", $product->name . " trashed   Successfully");
        } else {

        return back()->with("message","failed to delete category");
        }

}


public function recover($id)
{
// recover the data from traashed cand
$trashed = Product::onlyTrashed()->findOrFail($id);
if ($trashed->restore() ) {

// return redirect('admin/product')->with("message","trash item retstored successfully");
return back()->with("message","trash item retstored successfully");

} else {
return back()->with("message","failed to retriving trashed data");

}
}



public function trash()
{
$products = Product::onlyTrashed()->paginate(25);
return view('admin.products.trashed', compact('products') );
}


public function trashedItemDeletePermanetly($id)
{
    print_r($id);exit;
    $removeTrashedItem = Product::where('id', $id)->get();
        dd($removeTrashedItem);
        if ( $removeTrashedItem->forceDelete()  ) {

        return redirtect('admin/product/trash')->with("message"," trashed item deleted");
        // return back()->with("message"," trashed item deleted");
        } else {

        return back()->with("message","failed to delete trashed item");
        }  


}















}