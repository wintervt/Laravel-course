@extends('layout')

@section('content')
	<form action="{{ route('posts.store') }}" method='post' enctype="multipart/form-data">
		@csrf
		
		@include('posts._form')

		<button class="submit">Create</button>
	</form>
@endsection