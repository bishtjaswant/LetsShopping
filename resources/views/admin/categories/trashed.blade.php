@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}} ">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Trashed Category</li>
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h2 class="h2">Trashed  Categories</h2>
	
</div>
<div class="row">
	<div class="col-md-12 col-md-offset-6">
		@if (session()->has("message"))
		<div class="text-success">
			{{ session('message')}}
		</div>
		@endif
	</div>
</div>
@if ( isset($categories) && $categories->count() > 0 )
<div class="table-responsive">
	
	<table class="table table-hover">
		<thead>
			<tr>
				
				<th scope="col">Title</th>
				<th scope="col">Descriptions</th>
				<th scope="col">Added At</th>
				<th scope="col" colspan="3"> Handle Categories</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach ($categories as $category)
			<tr>
				<th scope="row"> {{  $category->title   }}   </th>
				<td>  {{  $category->descriptions    }}   </td>
				
				<td>  {{  $category->created_at->diffForHumans()    }}   </td>
				
				<td>
					
					<!--recover trashed items-->
					<a href="{{route('admin.category.recover', $category->id ) }}" class="btn btn-outline-success">Recover</a>
					
					<!--delete category to request-->
					
					<a href="javascript:void"
						onclick="event.preventDefault();
						const confirmedToDelete = confirm('Are you sure want to delete this trashed item permanetly.?');
						if(confirmedToDelete){
						document.getElementById('delete-trashed-category-form').submit();
						}"
					class="btn btn-outline-danger">Permanetly Delete</a>
					
					<form id="delete-trashed-category-form" 
					action="" 
					method="POST" style="display: none;">
						@csrf
						@method('DELETE')
					</form>
				</td>
			</tr>
			@endforeach
			
			
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-12">
		{{ $categories->links() }}
	</div>
</div>
@else
<p class="alert alert-warning text-center">no trashed item</p>
@endif
@endsection