@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="container container-md">
        <div class="row">
            <div class="col-md-6 h1">
                Темы
            </div>
            <div class="col-md-6">
                <form method="get" action="{{ route('topics.index') }}">
                    <div class="form-row">
                        <div class="col">
                            <select name="option" id="option" type="text" class="form-control">
                                <option value="id">id</option>
                                <option value="title">Название</option>
                                <option value="description">Описание</option>
                                <option value="body">Содержание</option>
                                <option value="is_featured">Рекомендованные</option>
                            </select>
                        </div>
                        <div class="col">
                            <input name="search" id="search" type="text" class="form-control" placeholder="Поиск">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="form-control btn btn-outline-dark">Найти</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach($topics as $topic)
                <div class="col-md-4 mt-3">
                    <div class="card h-100 shadow-sm">
                        <a href="{{ route('topics.show', $topic) }}">
                            <img style="object-fit: cover; max-height: 10rem;" src="{{ $topic->image }}" class="card-img-top">
                        </a>
                        <div class="card-body">
                            <h5 style="max-height: 2em;" class="card-title text-truncate">
                                {{ $topic->title }}
                                @if($topic->status == 0)
                                    (Черновик)
                                @endif
                            </h5>
                            <p style="max-height: 5em;" class="card-text text-truncate">{{ $topic->description }}</p>
                        </div>
                        <small style="padding: 0 0 20px 20px;" class="text-muted align-bottom">
                            <p>{{ $topic->category->title }}</p>
                            <p>{{ $topic->tags->implode('title', ', ') }}</p>
                            <a class="text-muted" href="{{ route('topics.show', $topic) }}">{{ $topic->id }}#</a>
                            <a class="text-muted" href="{{ route('profile.show', $topic->author->id) }}">{{ $topic->author->name }}</a>
                            @if($topic->created_at != $topic->updated_at)
                                UPD: {{ $topic->updated_at->diffForHumans() }}
                            @else
                                {{ $topic->created_at->diffForHumans() }}
                            @endif
                        </small>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row my-md-3">
            <div class="col-md-12">
                {{ $topics->appends(request()->all())->links() }}
                <a class="btn btn-primary mt-3" href="{{ route('topics.create') }}">Создать</a>
            </div>
        </div>
    </div>
@endsection
