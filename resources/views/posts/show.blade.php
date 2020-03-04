@extends('layout')

@section('content')

<div class="row">
	<div class="col-8">
		 <h1>{{ $post->title }}</h1>

		 @updated(['date' => $post->created_at, 'name' => $post->user->name ])
		 @endupdated

		 @tags(['tags' => $post->tags])
		 @endtags

		 <p>Currently read by {{ $counter }} people</p>
		
	 	<p>{{ $post->content }}</p>

		 {{-- <img src="{{ $post->image->url }}" alt="">  --}}

	 	<h4>Comments</h4>

	 	@forelse($post->comments as $comment)
			
			<p>{{ $comment->content }},</p>
			<p class="text-muted">Added {{ $comment->created_at->diffForHumans() }}</p>

	 	@empty
	 	<p>No comments yet!</p>
	 	@endforelse	
	</div>
	
	<div class="col-4">
		@include('posts._activity')
	</div>
</div>

 	
@endsection('content')
