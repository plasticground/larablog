@extends('layouts.app')

@section('content')
    <div class="container container-fluid bg-white p-md-3">
        <div class="row">
            <div class="col-md-12">
                <div class="h4 text-center">Личный кабинет</div>
                <p><small class="text-muted font-italic">Ваша карточка профиля: </small></p>
            </div>
        </div>
            <div class="card col-md-12 shadow-sm">
                <div class="card-body p-1">
                    <div class="row">
                        <div class="col-md-2 p-1 text-center">
                            <div class="card-img">
                                <img class="card-img img-thumbnail overflow-hidden rounded-circle" style="height: 150px; width: 150px;" src="{{ $user->avatar }}">
                            </div>
                        </div>
                        <div class="col-md-10 p-1">
                            <blockquote class="blockquote mb-0">
                                <p>{{ $user->name }}</p>
                                <footer class="blockquote-footer"><i>{{ $user->description }}</i></footer>
                            </blockquote>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-md-right">
                            <a class="text-muted font-italic" href="{{ route('profile.edit', $user) }}">Редактировать</a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row-cols-1 mt-md-3">
            <div class="col">
                <div class="h4 text-center">Ваши темы</div>
            </div>
        </div>
        <div class="row">
            @foreach($topics as $topic)
            <div class="col-md-4 my-3">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('topics.show', $topic) }}">
                        <img style="object-fit: cover; max-height: 10rem;" src="{{ $topic->image }}" class="card-img-top">
                    </a>
                    <div class="card-body">
                        <h5 style="max-height: 2em;" class="card-title text-truncate"> {{ $topic->title }}</h5>
                        <p style="max-height: 5em;" class="card-text text-truncate">{{ $topic->description }}</p>
                    </div>
                    <small style="padding: 0 0 20px 20px;" class="text-muted align-bottom">
                        <a class="text-muted" href="{{ route('topics.show', $topic) }}">{{ $topic->id }}#</a>
                        <a class="text-muted" href="">{{ $topic->author->name }}</a>
                        @if($topic->created_at != $topic->updated_at)
                            UPD: {{ $topic->updated_at->diffForHumans() }}
                        @else
                            {{ $topic->created_at->diffForHumans() }}
                        @endif
                    </small>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <a class="btn btn-primary" href="{{ route('topics.edit', $topic) }}">Edit</a>
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

        <div class="row my-3">
            <div class="col-md-12">
                {{ $topics->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
@endsection
