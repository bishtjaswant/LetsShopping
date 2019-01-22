@extends('admin.app')
@section('title')
  add product
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item "><a href="{{route('admin.product.index')}}">Products</a></li>
<li class="breadcrumb-item active" aria-current="page">Add/Edit Products</li>
@endsection
@section('content')
<h2 class="h1">Add Products</h2>
<form  action="{{ route('admin.product.store') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<div class="row">
		@csrf
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
				<input type="text" placeholder="title" id="texturl" name="title" class="form-control " value="{{old('title')}}"  />
					<p class="small">{{config('app.url')}}-<span id="url"> </span>
					<input type="hidden" name="slug" id="slug" value="{{old('slug')}}">
				</p>
			</div>
		</div>
		<div class="form-group row">
			
			<div class="col-lg-12">
				<label class="form-control-label">Description: </label>
				<textarea name="description" id="ckeditor" placeholder="description" class="form-control "> {{old('description')}}
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
					<input type="text" class="form-control" placeholder="0.00" aria-label="Username" aria-describedby="basic-addon1" name="price" value="{{old('price')}}" />
				</div>
			</div>
			<div class="col-6">
				<label class="form-control-label">Discount: </label>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">$</span>
					</div>
					<input type="text" class="form-control" name="discount_price" placeholder="0.00" aria-label="discount_price" aria-describedby="discount" value="{{old('discount_price')}}" />
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
						<option value="0" >Pending</option>
						<option value="1" >Publish</option>
					</select>
				</div>
				<div class="form-group row">
					<div class="col-lg-12">
						
						
						<input type="submit" name="submit" class="btn btn-primary btn-block " value="Add Product" />
						
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
					<img src="{{ URL::to('/') }}/images/noimage.jpeg" id="imgthumbnail" class="img-fluid" alt="thumbnail" height="500" width="500">
				</div>
			</li>
			<li class="list-group-item">
				<div class="col-12">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" ><input id="featured" type="checkbox" name="featured" value=" " ></span>
						</div>
						<p type="text" class="form-control" name="featured" placeholder="0.00" aria-label="featured" aria-describedby="featured" >Featured Product</p>
					</div>
				</div>
			</li>
			
			<li class="list-group-item active"><h5>Select Categories</h5></li>
			<li class="list-group-item ">
				<select name="category_id[]" id="select2" class="form-control" multiple="multiple">
					
					@if ($categories->count() >0 )
					@foreach ($categories as $category)
					<option value="{{$category->id}}"> {{$category->title }} </option>
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

//featured
$("#featured").on('change', function() {
	if($(this).is(':checked')){
		$(this).val(1);
	}else{
		$(this).val(0);
	}
});



		$('#select2').select2({
			"placeholder":"select multiple categories.....",
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

// extras options
$('#btn-add').on('click', function(e){
 
		var count = $('.options').length+1;
		$.get("{{route('admin.product.extras')}}").done(function(data){
			
			$('#extras').append(data);
		})
})
$('#btn-remove').on('click', function(e){	
	$('.options:last').remove();
})


});
</script>
@endsection