@extends('layout.app')
@section('title', $post->title)
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <article>
        <h2>{{ Str::ucfirst($post->title) }}</h2>
    </article>
    <p style="text-align: justify">
        {{ $post->content }}
    </p>
@endsection
