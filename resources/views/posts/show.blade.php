@extends('layout')

@section('content')

<div class="row">
	<div class="col-8">

		@if($post->image)
			<img class="img-fluid" src="{{ $post->image->url() }}" alt="">
		@else
			
		@endif

		 <h1>{{ $post->title }}</h1>

		 @updated(['date' => $post->created_at, 'name' => $post->user->name ])
		 @endupdated

		 @tags(['tags' => $post->tags])
		 @endtags

		 <p>Currently read by {{ $counter }} people</p>
		
	 	<p>{{ $post->content }}</p>


	 	<h4>Comments</h4>

	 	@include('comments._form')

	 	@forelse($post->comments as $comment)
			
			<p>{{ $comment->content }},</p>
			

		 @updated(['date' => $comment->created_at, 'name' => $comment->user->name ])
		 @endupdated

	 	@empty
	 	<p>No comments yet!</p>
	 	@endforelse	
	</div>
	
	<div class="col-4">
		@include('posts._activity')
	</div>
</div>

 	
@endsection('content')
