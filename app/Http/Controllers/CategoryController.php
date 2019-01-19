<?php
namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
$categories = Category::paginate(25);
return view('admin.categories.index', compact('categories'));
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
$categories = Category::all();
return view('admin.categories.create', compact('categories') ); // returning create category form
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{

$request->validate([
'title' => 'required|min:5',
'descriptions' => 'required|max:500',
// 'slug' => "required|min:5|unique:categories"
]);
$categories  = Category::create($request->only('title','descriptions','slug'));
$categories->childrens()->attach($request->parent_id);
$categories->save();
return back()->with("message","category added");
}
/**
* Display the specified resource.
*
* @param  \App\Category  $category
* @return \Illuminate\Http\Response
*/
public function show(Category $category)
{
//
}
/**
* Show the form for editing the specified resource.
*
* @param  \App\Category  $category
* @return \Illuminate\Http\Response
*/
public function edit(Category $category)
{
//
	$categories = Category::where('id','!=', $category->id)->get();
	return view('admin.categories.edit', [ 'categories'=>$categories, 'category'=>$category] );
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  \App\Category  $category
* @return \Illuminate\Http\Response
*/
public function update(Request $request, Category $category)
{
// valudate
	$request->validate([
	'title' => 'required|min:5',
	'descriptions' => 'required|max:500',
	'slug' => "required|min:5"
	]);

	$category->title = $request->title;
	$category->descriptions = $request->descriptions;
	$category->slug = $request->slug;


   // detach the recorrd
	$category->childrens()->detach();


    // attached
	$category->childrens()->attach($request->parent_id);
    

    // ssave the records into db
	$category->save();

	return back()->with("message","category Updated");

}
/**
* Remove the specified resource from storage.
*
* @param  \App\Category  $category
* @return \Illuminate\Http\Response
*/
public function destroy(Category $category)
{
//

	 if ($category->forceDelete() && $category->childrens()->detach() ) {
	 	
	      return back()->with("message","category deleted");
	 } else {
	 	
	return back()->with("message","failed to delete category");
	 }
}


public function remove(Category  $category)
{
	 if ($category->delete()) {
	 	
	      return back()->with("message","category trashed   Successfully");
	 } else {
	 	
	return back()->with("message","failed to delete category");
	 }

}


public function recover($id)
{
	// recover the data from traashed cand
	$trashed = Category::onlyTrashed()->findOrFail($id);
	if ($trashed->restore() ) {
	return back()->with("message","category retstored successfully");
		
	} else {
	return back()->with("message","failed to retriving trashed data");
		
	}
}


public function trash()
{
$categories = Category::onlyTrashed()->paginate(25);
return view('admin.categories.trashed', ['categories'=> $categories]);	
}
 

public function trashedItemDeletePermanetly($id)
{ 
   	 /*if ( Category::findOrFail($id)->forceDelete()  ) {
	 	
	      return back()->with("message","permanetly trashed item deleted");
	 } else {
	 	
	return back()->with("message","failed to delete trashed item");
	 }	*/
}





}