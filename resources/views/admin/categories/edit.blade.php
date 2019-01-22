@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}} ">Dashboard</a></li>
<li class="breadcrumb-item" >Category</li>
<li class="breadcrumb-item active" aria-current="page">Edit Category</li>
@endsection
@section('content')
<form action=" {{ route('admin.category.update', $category->id ) }}  " method="post" accept-charset="utf-8">
	
	<h2>Update category</h2>
	
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
	</div>
	<div class="form-group row">
		<div class="col-sm-12">
			@if (session()->has("message"))
			<div class="alert alert-info">
				{{ session('message')}}
			</div>
			@endif
		</div>
	</div>
	@csrf
	@method('PUT')
	
	<div class="form-group row">
		<div class="col-sm-12">
			<label class="form-control-label"> Title </label>
			<input type="text" size="50" id="texturl" name="title" class="form-control" placeholder="enter category name here.........." value="{{ $category->title }}">
			<p class="small text-muted">      {{ config('app.url')}}/<span id="url"> {{ $category->slug }} </span> </p>
			<input type="hidden" name="slug" id="slug" value="{{ $category->slug }}">
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-12">
			<label class="form-control-label"> Description </label>
			<textarea id="ckeditor" rows="10" cols="20" name="descriptions" class="form-control" placeholder="enter category description here.........." style="resize: none;"> {{ $category->descriptions }}  </textarea>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-12">

			@php
              $ids = array_pluck($category->childrens  , 'id')
			@endphp
 
			<label class="form-control-label"> Select category </label>
			<select id="parent_id" multiple="multiple" name="parent_id[]" class="form-control">
				@if ( isset($categories) )
				<option value="0">top level</option>
	
				@foreach ( $categories  as $category )
	
				<option  value=" {{  $category->id }} "
                         
                         selected
					>   {{ $category->title }}   </option>
	
				@endforeach
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-12">
			<button type="submit" name="save" class=" btn btn-outline-primary">Update categoy</button>
			<a href="{{route('admin.category.index')}}  " class="btn btn-outline-success"> Back</a>
		</div>
	</div>
</form>
@endsection
@section('custome_script')
<script type="text/javascript">
$(function() {
	
// select2
$('#parent_id').select2({
	"placeholder":"choose a parrent category",
"allowClear":true,
	"minimumResultsForSearch":Infinity
	});
// ckeditor
ClassicEditor
.create( document.querySelector( '#ckeditor' ), {
toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote','undo','redo' ],
} )
.then(editor=>{
	console.log(editor);
})
.catch( error => {
console.log( error );
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
});
</script>
@endsection