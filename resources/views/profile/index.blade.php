@extends('layouts.app')

@section('content')
    <div class="container container-fluid">
        <div class="row">
            <div class="col col-md-12">
                <div class="h3 font-italic">Добро пожаловать в личный кабинет, {{ $user->name }}.</div>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-8">
                Информация о пользователе
            </div>
            <div class="col col-md-4">
                <img class="w-25 h-25" src="" alt="">
            </div>
        </div>
        <div class="h4">Мои темы:</div>
        <div class="row">
            @foreach($user->topics as $topic)
            <div class="col-md-4 mt-3">
                <div class="card h-100 shadow-sm">
                    <a href="topics/{{ $topic->id }}">
                        <img style="object-fit: cover; max-height: 10rem;" src="{{ $topic->image }}" class="card-img-top">
                    </a>
                    <div class="card-body">
                        <h5 style="max-height: 2em;" class="card-title text-truncate"> {{ $topic->title }}</h5>
                        <p style="max-height: 5em;" class="card-text text-truncate">{{ $topic->description }}</p>
                    </div>
                    <small style="padding: 0 0 20px 20px;" class="text-muted align-bottom">
                        <a class="text-muted" href="topics/{{ $topic->id }}">{{ $topic->id }}#</a>
                        <a class="text-muted" href="">{{ $topic->author->name }}</a>
                        @if($topic->created_at != $topic->updated_at)
                            UPD: {{ $topic->updated_at }}
                        @else
                            {{ $topic->created_at }}
                        @endif
                    </small>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <a class="btn btn-primary" href="{{ $topic->id }}/edit">Edit</a>
                            <form class="d-md-inline" method="post" action="{{ route('topics.destroy', $topic) }}">
                                @method('DELETE')
                                @csrf
                                <button onclick="return confirm('Подтвердите удаление');" value="{{ $topic }}" type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
