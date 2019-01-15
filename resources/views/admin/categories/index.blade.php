@extends('admin.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	
	<div class="h2">All categories list</div>
	<div class="btn-toolbar mb-2 mb-md-0">
		<a href="{{ route('admin.category.create')  }}"  class="btn btn-sm btn-outline-secondary float-right"> create category</a>
	</div>
	
</div>
@if ($categories)

<div class="table-responsive">
	
	<table class="table table-hover">
		<thead>
			<tr>
				
				<th scope="col">Title</th>
				<th scope="col">Descriptions</th>
				<th scope="col">Slug</th>
				<th scope="col"> Categories </th>
				<th scope="col">Added At</th>
				<th scope="col" colspan="3"> Handle Categories</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach ($categories as $category)
			<tr>
				<th scope="row"> {{  $category->title   }}   </th>
				<td>  {{  $category->descriptions    }}   </td>
				<td>  {{  $category->slug    }}   </td>
				<td>
					
					<!--parent category-->
					@if ( $category->childrens()->count() > 0 )
					@foreach ( $category->childrens as $child )
					{{$child->title }} ,
					@endforeach
					@else
					<strong>  {{'parent category'}} </strong>
					@endif
				</td>
				<td>  {{  $category->created_at    }}   </td>
				
				<td>
					<a href="" class="btn btn-outline-success">Edit</a>
					<a href="" class="btn btn-outline-danger">Delete</a>
				</td>
			</tr>
			@endforeach
			
			
		</tbody>
	</table>
</div>
@else
<p>no category available</p>
@endif
@endsection