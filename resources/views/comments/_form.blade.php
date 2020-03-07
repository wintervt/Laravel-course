	<div class="my-2">
		@auth
			<form action="{{ route('posts.comments.store', ['post' => $post->id]) }}" method='post' enctype="multipart/form-data">
				@csrf
				
				<textarea type="text" name="content" class="form-control"></textarea>

				<button class="submit" class="btn btn-primary">Add Comment</button>
			</form>
			@errors @enderrors
		@else
			<a href="{{ route('login') }}">Sign-in to post comments!</a>
		@endauth
	</div>