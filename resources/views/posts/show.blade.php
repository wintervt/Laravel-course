@extends('layout')

@section('content')
 	<h1>{{ $post->title }}</h1>

	<p>Added {{ $post->created_at->diffForHumans() }}</p>
	
 	<p>{{ $post->content }}</p>

	 {{-- <img src="{{ $post->image->url }}" alt="">  --}}

 	<h4>Comments</h4>

 	@forelse($post->comments as $comment)
		
		<p>{{ $comment->content }},</p>
		<p class="text-muted">Added {{ $comment->created_at->diffForHumans() }}</p>

 	@empty
 	<p>No comments yet!</p>
 	@endforelse
 	
@endsection('content')
