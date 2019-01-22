@extends('admin.app')
@section('title')
  all products
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Products</li>
@endsection
@section('content')
<div class="row d-block">
  <div class="col-sm-12">
    @if (session()->has('message'))
    <div class="alert alert-success">
      {{session('message')}}
    </div>
    @endif
  </div>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h2 class="h2">Products List</h2>
  <div class="btn-toolbar mb-2 mb-md-0">
    <a href="{{route('admin.product.create')}}" class="btn btn-sm btn-outline-secondary">
      Add Product
    </a>
     
  </div>
</div>
<div class="table-responsive">
  @if (isset($products) && count($products) > 0 )
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Description</th>
        <th>Slug</th>
        <th>Categories</th>
        <th>Price</th>
        <th>Thumbnail</th>
        <th>Date Created</th>
        <th colspan="5">Actions</th>
      </tr>
    </thead>
    <tbody>
       @foreach ($products as $product)
           <tr>
               <td> {{ $product->id }} </td>
                <td> {{ $product->name }} </td>
                <td> {{ $product->descriptions  }} </td>
                <td> {{ $product->slug }} </td>
                <td>
                  @if ($product->categories()->count()>0)
                  @foreach ( $product->categories as $pro_child )
                  {{ $pro_child->title }}
                  @endforeach
                  @endif
                </td>
                <td> {{ $product->price }} </td>


               <td>
                <img src="{{Storage::disk('public')->url('/products/'.$product->thumbnail ) }}" alt=" {{$product->title }} " height="80" width="100" class="img img-thumbnail img-responsive"> </td>
                  
                <td>{{$product->created_at }}          </td>
                    
                <td>
                  

          <a href="{{ route('admin.product.edit', $product->slug ) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
          

         <a href="{{ route('admin.product.remove', $product->slug ) }}" class="btn btn-sm btn-outline-primary">Trash</a>




          
{{-- deleting --}}
          <a href="javascript:void"
            onclick="event.preventDefault();
            const confirmedToDelete = confirm('Are you sure want to delete this product permanetly.?');
            if(confirmedToDelete){
            document.getElementById('delete-product-form').submit();
            }"  class="btn btn-sm btn-outline-danger">Delete</a>
          
          <form id="delete-product-form" action="{{ route('admin.product.destroy', $product->slug ) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
          </form>

                </td>

           </tr>
       @endforeach
    </tbody>
  </table>
  @else
  <p class="alert alert-danger"> there are no products yet</p>
  @endif
  
</div>
<div class="row">
  <div class="col-md-12">
    {{-- {{$products->links()}} --}}
  </div>
</div>
@endsection
@section('custome_script')

@endsection