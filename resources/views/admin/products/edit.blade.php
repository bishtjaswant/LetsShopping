@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item "><a href="{{route('admin.product.index')}}">Products</a></li>
<li class="breadcrumb-item active" aria-current="page">Edit Products</li>
@endsection
@section('content')
<h2 class="h1">Edit Products</h2>
<form  action="{{ route('admin.product.update', $product ) }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<div class="row">
		@csrf
		@method('PUT')
		<div class="col-lg-9">
			<div class="form-group row">
				
				<div class="col-sm-12">
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
				</div>
				<div class="col-sm-12">
					@if (session()->has('message'))
					<div class="alert alert-success">
						{{session('message')}}
					</div>
					@endif
				</div>
				<div class="col-lg-12">
					<label class="form-control-label">Title: </label>
				<input type="text" placeholder="title" id="texturl" name="title" class="form-control " value="{{ $product->name}}"  />
					<p class="small">{{config('app.url')}}-<span id="url"> </span>
					<input type="hidden" name="slug" id="slug" value="{{ $product->slug }}">
				</p>
			</div>
		</div>
		<div class="form-group row">
			
			<div class="col-lg-12">
				<label class="form-control-label">Description: </label>
				<textarea name="description" id="ckeditor" placeholder="description" class="form-control "> {{ $product->descriptions }}
				</textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-6">
				<label class="form-control-label">Price: </label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">$</span>
					</div>
					<input type="text" class="form-control" placeholder="0.00" aria-label="Username" aria-describedby="basic-addon1" name="price" value="{{ $product->price }}" />
				</div>
			</div>
			<div class="col-6">
				<label class="form-control-label">Discount: </label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">$</span>
					</div>
					<input type="text" class="form-control" name="discount_price" placeholder="0.00" aria-label="discount_price" aria-describedby="discount" value="{{ $product->discount_price }}" />
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="card col-sm-12 p-0 mb-2">
				<div class="card-header align-items-center">
					<h5 class="card-title float-left">Extra Options</h5>
					<div class="float-right" >
						<button type="button" id="btn-add" class="btn btn-primary btn-sm">+</button>
						<button type="button" id="btn-remove" class="btn btn-danger btn-sm">-</button>
					</div>
					
				</div>
				
				{{-- extras item --}}
				<div class="card-body" id="extras">
					<div class="row align-items-center options">
						<div class="col-sm-4">
							<label class="form-control-label">option <span class="count">1</span></label>
							<input type="text" name="extras[options][]" class="form-control" placeholder="option1|options2|options3" id="">
						</div>
						<div class="col-sm-8">
							<label class="form-control-label">Values</label>
								<input type="text" name="extras[values][]" class="form-control" placeholder="values1|values2|values3"  value="" id="">
							<label for="" class="form-control-label">Price</label>
							<input type="text" name="extras[price][]" class="form-control" placeholder="price1|price2|price3" id="" value="">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<ul class="list-group row">
			<li class="list-group-item active"><h5>Status</h5></li>
			<li class="list-group-item">
				<div class="form-group row">
					<select class="form-control" id="status" name="status">
						<option value="0" @if (isset($product) && $product->status==0)
							{{'selected'}}	@endif >Pending</option>

						<option value="1"  @if (isset($product) && $product->status==1)
							{{'selected'}}	@endif >Publish</option>
					</select>
				</div>
				<div class="form-group row">
					<div class="col-lg-12">
						
						
						<input type="submit" name="submit" class="btn btn-success btn-block " value="Update Product" />
						
					</div>
					
				</div>
			</li>
			<li class="list-group-item active"><h5>Feaured Image</h5></li>
			<li class="list-group-item">
				<div class="input-group mb-3">
					<div class="custom-file ">
						<input type="file"  class="custom-file-input" name="thumbnail" id="thumbnail">
						<label class="custom-file-label" for="thumbnail">Choose file</label>
					</div>
				</div>
				<div class="img-thumbnail  text-center">
					<img src="{{ Storage::disk('public')->url('products/'. $product->thumbnail) }}" id="" class="img-fluid" alt="{{ $product->name }}" height="500" width="500">
				</div>
			</li>
			<li class="list-group-item">
				<div class="col-12">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" ><input id="featured" type="checkbox" name="featured" value=""  @if (isset($product) && $product->featured==1)
							{{'checked'}}	@endif   >  </span>
						</div>
						<p type="text" class="form-control" name="featured" placeholder="0.00" aria-label="featured"   aria-describedby="featured" >Featured Product</p>
					</div>
				</div>
			</li>
			
			<li class="list-group-item active"><h5>Select Products</h5></li>
			<li class="list-group-item ">
				<select name="category_id[]" id="select2" class="form-control" multiple="multiple">
					@php
						$ids = ( isset($product) && $product->categories->count()>0) ? array_pluck($product->categories,'id') : null;
						// dd($ids);
					@endphp
					@if ($categories->count() >0 )
					@foreach ($categories as $category)
					<option value="{{$category->id}}" 
                     @if (!is_null($product) && in_array($category->id, $ids ))
                     	{{'selected'}}
                     @endif	> 
                     
					{{$category->title }} </option>
				

					@endforeach
					
					@endif
					
				</select>
			</li>
		</ul>
	</div>
</div>
</form>
@endsection
@section('custome_script')
<script type="text/javascript">
jQuery(document).ready(function($) {
	
		ClassicEditor.create( document.querySelector( '#ckeditor' ), {
		toolbar: [ 'Heading', 'Link', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote','undo', 'redo' ],
	})
.then( editor => {
console.log( editor );
} )
.catch( error => {
console.error( error );
} );
 

	// validate slug
$('#texturl').on('keyup', function(event) {
    const url = slugify( $(this).val() );
	$('#url').html(url);
	$('#slug').val(url);
});

// slluug ify
function slugify(text){ 
return text.toString().toLowerCase()
.replace(/\s+/g, '-')           // Replace spaces with -
.replace(/[^\w\-]+/g, '')       // Remove all non-word chars
.replace(/\-\-+/g, '-')         // Replace multiple - with single -
.replace(/^-+/, '')             // Trim - from start of text
.replace(/-+$/, '');            // Trim - from end of text
}


		$('#select2').select2({
			"placeholder":"select multiple products.....",
		"allowClear":true,
			"minimumResultsForSearch":Infinity
			});
		
		$('#status').select2({
		placeholder: "Select a status",
		allowClear: true,
		minimumResultsForSearch: Infinity
		});
// uploading photo
$('#thumbnail').change(function(event) {
	const pic =  $(this).get(0).files;
	const reader = new FileReader();
	reader.readAsDataURL(pic[0]);
	reader.addEventListener('load', function(e) {
		const img = e.target.result;
		$('#imgthumbnail').attr('src',img)
	})
});

//featured
$("#featured").on('change', function() {
	if($(this).is(':checked')){
		$(this).val(1);
	}else{
		$(this).val(0);
	}
});


});
</script>
@endsection