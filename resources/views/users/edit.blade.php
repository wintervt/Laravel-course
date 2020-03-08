@extends('layout')

@section('content')
	
	<form method="POST" action="{{ route('users.update', ['user' => $user->id ]) }}" class="form-horizontal" enctype="multipart/form-data">
	 @csrf
	 @method('PUT')

	 <div class="row">
	 	<div class="col-12 col-md-4">
	 		<img src="{{ $user->image ? $user->image->url() : '' }}" alt="" class="img-thumbnail avatar">
	 		<div class="card mt-4">
	 			<div class="card-body">
	 				<h5>Upload a different avatar</h5>
	 				<input type="file" class="form-control-class" name="avatar">
	 			</div>
	 		</div>
	 	</div>
	 	<div class="col-12 col-md-8">
	 		<div class="fomr-group">
	 			<label for="">Name</label>
	 			<input type="text" name="name" value="" class="form-control">
	 		</div>

	 		@errors @enderrors
	 		
	 		<div class="form-group">
	 			<input type="submit" class="btn btn-primary" value="Save changes">
	 		</div>
	 	</div>
	 </div>	
	</form>

@endsection