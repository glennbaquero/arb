@extends('guest.master')

@section('meta:title', 'Articles')

@section('content')

<div class="container-fluid my-5">

	<article-list
    fetch-url="{{ route('guest.articles.fetch') }}"
    >
    	@include('guest.partials.content-placeholder')
    </article-list>
    
</div>

@endsection