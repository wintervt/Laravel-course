@extends('layout')

@section('content')
	<div class="row">
		<div class="col-8">
		@forelse ($posts as $post)
			<p>

				<h3>
					@if($post->trashed())
						<del>
					@endif
						<a class="{{ $post->trashed() ? 'text-muted' : '' }}" href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
					@if($post->trashed())
						</del>
					@endif
				</h3>

				{{-- <p class="text-muted">Added {{  $post->created_at->diffForHumans() }}
				 by {{ $post->user->name }}</p>
 --}}
				 @updated(['date' => $post->created_at, 'name' => $post->user->name ])
				 @endupdated

				 @tags(['tags' => $post->tags])
				 @endtags

				@if($post->comments_count)
					<p>{{ $post->comments_count}} comments</p>
				@else
					<p>No comments yet</p>
				@endif	

				@can('update', $post)
				 <a class="btn btn-primary" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit</a>
				@endcan
				
				@auth
					@if(!$post->trashed())
						@can('delete', $post)
							<form class="fm-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method='post'>
							@csrf
							@method('DELETE')

							<input type="submit" value="Delete!" class="btn btn-danger">
							</form>
						@endcan
					@endif
				@endauth

			</p>
		@empty
			<p>No blog posts yet!</p>
		@endforelse
		</div>
		<div class="col-4">
			<div class="container">
				<div class="row">
					@card(['title' => 'Most Commented', 'subtitle' => 'What are people currently talking about'])
						@slot('items')
							@foreach ($mostCommented as $post)
							    <li class="list-group-item"><a href="{{ route('posts.show', ['post' => $post->id ]) }}">{{ $post->title }}</a></li>
							@endforeach
						@endslot
					@endcard
				</div>

				<div class="row">
					@card(['title' => 'Most Active', 'subtitle' => 'Users with the most posts written'])
						@slot('items', collect($mostActive)->pluck('name'))
					@endcard
				</div>

				<div class="row">
					@card(['title' => 'Most Active Last Month', 'subtitle' => 'Users with the most posts written last month'])
						@slot('items', collect($mostActiveLastMonth)->pluck('name'))
					@endcard
				</div>

			</div>
		</div> 
	</div>
@endsection