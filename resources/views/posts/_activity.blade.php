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