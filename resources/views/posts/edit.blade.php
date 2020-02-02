@extends('layout')

@section('content')
	<form action="{{ route('posts.update', ['post' => $post->id]) }}" method='post'>
		@csrf
		@method('PUT')

		@include('posts._form')

		<button class="submit" class="btn btn-primary">Update</button>
	</form>
@endsection