@extends('layouts.app')

@section('content')

    <div class="container container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="container text-break bg-white">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $topic->title }}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 font-italic text-muted">
                    {{ $topic->category->title }} / {{ $topic->tags->implode('title', ', ') }}
                    <hr>
                </div>
            </div>
            <div class="row mb-md-3">
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ $topic->image }}" alt="">
                </div>
                <div class="col-md-6">
                    <blockquote class="blockquote">
                        {{ $topic->description }}
                    </blockquote>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <blockquote class="blockquote">
                        {!! $topic->body !!}
                    </blockquote>
                </div>
            </div>
            @auth
                @if($topic->author->is(auth()->user()))
                    <div class="row py-md-3 text-md-right">
                        <div class="col-md-12">
                            <a class="btn btn-primary" href="{{ route('topics.edit', $topic) }}">Edit</a>
                            <form style="display: inline" method="post" action="{{ route('topics.destroy', $topic) }}">
                                @method('DELETE')
                                @csrf
                                <button onclick="return confirm('Подтвердите удаление');" value="{{ $topic }}" type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
        @auth
        <div class="container text-break bg-white mt-md-3">
            <form method="post" action="{{ route('comment.store', ['topic_id' => $topic->id, 'user_id' => auth()->user()->id]) }}">
                @csrf
                <div class="input-group py-md-3">
                    <textarea class="form-control" name="text" placeholder="Написать комментарий">{{ old('text') }}</textarea>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>
                </div>
            </form>
            @error('text')
            <small class="form-text text-muted pb-md-3">{{ $message }}</small>
            @enderror
        </div>
        @endauth
        @if($comments->isNotEmpty())
        <div class="container text-break bg-white mt-md-3 py-md-1">
            @foreach($comments as $comment)
                <div class="card my-md-2 px-md-2 shadow-sm">
                    <div class="row">
                        <div class="col-md-auto text-center m-md-2">
                            <a href="{{ route('profile.show', $comment->author) }}" class="text-secondary">
                                <div class="card-img">
                                    <img class="card-img img-thumbnail overflow-hidden rounded-circle" style="height: 100px; width: 100px;" src="{{ $comment->author->avatar }}">
                                </div>
                                <p>{{ $comment->author->name }}</p>
                            </a>
                            <p class="text-secondary">{{ $comment->created_at->diffForHumans() }}</p>
                            @if($comment->author->is(auth()->user()) || auth()->user()->role == 1)
                                <form method="post" action="{{ route('comment.destroy', $comment) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button onclick="return confirm('Подтвердите удаление');" value="{{ $comment }}" type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                            @endif
                        </div>
                        <div class="col-md-10 m-md-2">
                            <blockquote class="blockquote">
                                {{ $comment->text }}
                            </blockquote>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>

@endsection
