
@extends('admin.app')
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
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>rrty</td>
        <td>rrty</td>
        <td>rrty</td>
        <td>rrty</td>
        <td>rrty</td>
        <td>rrty</td>
        <td>rrty</td>
        <td>rrty</td>
      </tr>
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
    {{-- {{$products->links()}} --}}
  </div>
</div>
@endsection
@section('custome_script')
 
@endsection