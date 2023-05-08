@extends('layout.app')
@section('title', $post->exists ? 'Editer un post' : 'Créer un post')
@section('content')
    <h2>@yield('title')</h2>

    <form action="{{ $post->exists ? route('posts.update', $post) : route('posts.store') }}" method="post" class="col-4"
        enctype="multipart/form-data">
        @csrf @method($post->exists ? 'PUT' : 'POST')
        <div>
            <div class="form-group mb-2">
                <input id="title" placeholder="Post title" type="text" value="{{ $post->title }}"
                    class="@error('title') is-invalid @enderror form-control" name="title">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <input id="image" type="file" class="@error('image') is-invalid @enderror form-control"
                    name="image" value="{{ $post->image }}">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group mb-2">
                <textarea placeholder="Post content" name="content" class="@error('content') is-invalid @enderror form-control">{{ $post->content }}</textarea>
                @error('content')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary col-3">
                @if ($post->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>
    </form>
@endsection
@section('script')
    <script>
        $(function() {
            $('input[name="title"]').focus();
            $('input[name="title"], textarea[name="content"]').on('input', function() {
                $('#errors').hide();
            });
        });
    </script>
@endsection
