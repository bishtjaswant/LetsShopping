@extends('admin.app')
@section('title')
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
  Add new user
@endsection
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
<li class="breadcrumb-item "><a href="{{route('admin.profile.index')}}">users</a></li>
<li class="breadcrumb-item active" aria-current="page">Add/Edit users</li>
@endsection
@section('content')
<h2 class="modal-title">Add/Edit users</h2>
<form  action=" {{route('admin.profile.store')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
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
				<div class="col-sm-12 col-md-6">
					<label class="form-control-label">Name: </label>
			
					<input type="text" id="txturl" name="name" placeholder="enter your name?" class="form-control " value="" title="name must be a string" />
					<p class="small">{{route('admin.profile.index')}}/<span id="url">-----</span>
					<input type="hidden" name="slug" id="slug" value="">
				</p>
			</div>
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Email: </label>
				<input type="text" placeholder="enter email address to contact" id="email" name="email" class="form-control " value="" title="please gives us a valid email address" />
				
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Password: </label>
				<input type="password" placeholder="enter a strong password" id="password" name="password" class="form-control " value="" title="password must be 8 digit long with special chars" />
				
			</div>
			<div class="col-sm-12 col-md-6">
				<label class="form-control-label">Re-Type Password: </label>
				<input type="password" placeholder="enter again your password" id="password_confirm" name="password_confirm" class="form-control " value="" title="password must be 8 digit long with special chars" />
				
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<label class="form-control-label">Status</label>
				<div class="input-group mb-3">
					<select class="form-control" id="status" name="status">
						<option value="1">Active</option>
						<option value="0" >Blocked</option>
					</select>
				</div>
			</div>
		  
			
			<div class="col-sm-6">
				<label class="form-control-label">Select Role</label>
				<select title="select a role" name="role_id" id="role" class="form-control">
					 <option value="1">Customer</option>
					 <option value="2">Retailer</option>
					 <option value="3">Admin</option>  
				</select>
			</div>
		</div>
		<div class="row">
			<h4 class="title">Address</h4>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">
				<label class="form-control-label">Address: </label>
				<div class="input-group mb-3">
					<textarea placeholder="enter your complete address" title="enter your complete address" name="address" class="form-control " value="" cols="10" rows="5"style="resize: none;" > </textarea>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">Country: </label>
				<div class="input-group mb-3">
					<select name="country_id" class="form-control" id="countries">
						 @if (isset($countries) && $countries->count()>0)
						   <option value="0">select a country</option>
						 	@foreach ($countries as $country)      	
						 		<option value="{{$country->id}}"> {{ $country->name }} </option>
						 	@endforeach
						 @endif
					
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">State: </label>
				<div class="input-group mb-3">
					<select name="state_id" title="select your state" class="form-control" id="states">
						<option value="0">Select a State</option>
					</select>
				</div>
			</div>
			
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">City: </label>
				<div class="input-group mb-3">
					<select title="select your city" name="city_id" class="form-control" id="cities">
						<option value="0">Select your city</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-3">
				<label class="form-control-label">Phone: </label>
				<div class="input-group mb-3">
					<input type="number" class="form-control" name="phone" title="please give us valid number" placeholder="Phone number" value="" />
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<ul class="list-group row">
			
			<li class="list-group-item active"><h5>Profile Image</h5></li>
			<li class="list-group-item">
				<div class="input-group mb-3">
					<div class="custom-file ">
						<input type="file"  class="custom-file-input" name="thumbnail" id="thumbnail">
						<label class="custom-file-label" for="thumbnail">Choose file</label>
					</div>
				</div>
				<div class="img-thumbnail  text-center">
					<img src="{{Storage::disk('public')->url('users/nouser.png')  }}" id="imgthumbnail" class="img-fluid" alt="user-profile">
				</div>
			</li>
			<li class="list-group-item">
				<div class="form-group row">
					<div class="col-lg-12">
						 
						<input type="submit" name="submit" class="btn btn-primary btn-block " value="Save user" />
					 
					</div>
					
				</div>
			</li>
		</ul>
	</div>
</div>
</form>
@endsection
@section('custome_script')
<script type="text/javascript">
	$(function(){
		$('#txturl').on('keyup', function(){
			const pretty_url = slugify($(this).val());
			$('#url').html(slugify(pretty_url));
			$('#slug').val(pretty_url);
		})
$('#thumbnail').on('change', function() {
var file = $(this).get(0).files;
var reader = new FileReader();
reader.readAsDataURL(file[0]);
reader.addEventListener("load", function(e) {
var image = e.target.result;
$("#imgthumbnail").attr('src', image);
});
});
// Set up the Select2 control
$('#countries').select2().trigger('change');
$('#states').select2();
$('#cities').select2();
//On Country changes
$('#countries').on('change', function(event) {
	event.preventDefault();
	const selectedContryId = $(this).select2('data')[0].id;
	$('#states').val(null);
	$('#states option').remove();
	// Fetch the preselected item, and add to the control
 const states = $('#states');
$.ajax({
    type: 'GET',
    url: "{{route('admin.profile.states') }}/" + selectedContryId,
}).then(function (data) {
    // create the option and append to Select2
    for (var i = 0; i <= data.length; i++) {
    	let item =  data[i];;

		   let option = new Option(item.name, item.id, true, true);
		    states.append(option).trigger('change');
    }
});


});

//On state Change

$('#states').on('change', function(event) {
	event.preventDefault();
	const selectedStateId = $(this).select2('data')[0].id;
	// Fetch the preselected item, and add to the control
	$('#cities').val(null);
	$('#cities option').remove();
 const cities = $('#cities');
$.ajax({
    type: 'GET',
    url: "{{route('admin.profile.cities') }}/" + selectedStateId,
}).then(function (data) {
    // create the option and append to Select2
    for (var i = 0; i <= data.length; i++) {
    	let item =  data[i];;

		   let option = new Option(item.name, item.id, true, true);
		    cities.append(option).trigger('change');
    }
});


});






}); // jquery
</script>
@endsection