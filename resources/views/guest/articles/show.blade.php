@extends('guest.master')

@section('meta:title', $item->renderName())

@section('content')

<div class="container my-5">
	<selected-article
	fetch-url="{{ route('guest.articles.fetch-item', $item->id) }}"
	>
		@include('guest.partials.content-placeholder')
	</selected-article>
</div>

@endsection