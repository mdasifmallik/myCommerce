@extends('layouts.frontend_app')

@section('title')
{{config('app.name')}} | About
@endsection

@section('frontend_content')
	<div class="container">
		<div class="row" style="padding: 40px 0">
			<div class="col-md-12">
				<h1>This is About page.</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime dolorum nemo, molestias sapiente quis similique quod quidem odio dolores quia a nihil eos incidunt velit porro! Impedit ab adipisci, corporis?</p>
			</div>
		</div>
	</div>
@endsection
