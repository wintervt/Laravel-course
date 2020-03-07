@if($errors->any())
	<div class="my-2">
			@foreach($errors->all() as $error)
				<div class="alert alert-danger">{{ $error }}</div>
			@endforeach
	</div>	
@endif