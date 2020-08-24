@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="container container-md">
        <div class="row">
            @foreach($topics as $topic)
                <div class="col-md-4 mt-3">
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
                <a class="btn btn-primary mt-3" href="topics/create">Создать</a>
            </div>
        </div>
    </div>
@endsection
