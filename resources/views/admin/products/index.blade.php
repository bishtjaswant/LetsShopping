@extends('admin.app')


@section('breadcrumbs')

    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}} ">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Product</li>
@endsection

@section('content')
<h1>hello poduct</h1>
@endsection