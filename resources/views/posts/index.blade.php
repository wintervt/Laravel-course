@extends('layout')

@section('content')
	@forelse ($posts as $post)
		<p>
			<h3><a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></h3>

			<p class="text-muted">Added {{  $post->created_at->diffForHumans() }}
			 by {{ $post->user->name }}</p>

			@if($post->comments_count)
				<p>{{ $post->comments_count}} comments</p>
			@else
				<p>No comments yet</p>
			@endif	

			<a class="btn btn-primary" href="{{ route('posts.edit', ['post' =>$post->id]) }}">Edit</a>

			<form class="fm-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method='post'>
			@csrf
			@method('DELETE')

			<input type="submit" value="Delete!" class="btn btn-danger">
			</form>

		</p>
	@empty
		<p>No blog posts yet!</p>
	@endforelse 
@endsection