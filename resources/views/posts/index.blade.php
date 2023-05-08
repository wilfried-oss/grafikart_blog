@extends('layout.app')
@section('title', 'Posts')
@section('content')

    <div class="d-flex justify-content-between">
        <h2>Liste Posts</h2>
        <a class="btn btn-primary" href="{{ route('posts.create') }}">Nouveau Post</a>
    </div>
    <hr>
    @foreach ($posts as $post)
        <article>
            <h4>{{ Str::ucfirst($post->title) }}</h4>
        </article>
        <p style="text-align: justify">
            {{ $post->content }}
        </p>

        @if ($post->image)
            <img style="width: 100%; height: 200px; object-fit: cover" src="{{ $post->imageUrl() }}" alt="logo">
        @endif
        <hr>
        <div class="mt-3 col d-flex justify-content-center  gap-5">
            <a class="btn btn-success" href="{{ route('posts.show', $post->id) }}">Show post</a>
            <a class="btn btn-primary" href="{{ route('posts.edit', $post->id) }}">Update post</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                @csrf @method('delete')
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
        <hr>
    @endforeach
    {{ $posts->links() }}
@endsection
