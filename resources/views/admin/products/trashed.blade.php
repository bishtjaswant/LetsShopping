@extends('admin.app')
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item active" aria-current="page">Trashed Products</li>
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
  <h2 class="h2">Trashed List</h2>
 
</div>
<div class="table-responsive">
  @if (count($products) > 0 )
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
        <td> <img src="{{Storage::disk('public')->url('/products/'.$product->thumbnail ) }}" alt=" {{ $product->title }} " height="80" width="100" class="img img-thumbnail img-responsive"> </td>
        <td>
          <p>{{$product->created_at }} </p>
        </td>
        <td>

          <a href="{{ route('admin.product.recover', $product->id ) }}" class="btn btn-sm btn-outline-primary">Recover</a>
           
            
{{-- deleting --}}
          <a href="javascript:void"
            onclick="event.preventDefault();
            const confirmedToDelete = confirm(`Are you sure want to remove this  item from trashed cand permanetly.?`);
            if(confirmedToDelete){
            document.getElementById('delete-trashed-form').submit();
            }"  class="btn btn-sm btn-outline-danger">Remove</a>
          
          <form id="delete-trashed-form" action="{{ route('admin.product.removeTrashed', $product->id ) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
          </form>

        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <p class="alert alert-danger"> there are no trashed products yet</p>
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