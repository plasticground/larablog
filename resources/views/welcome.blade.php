@extends('layouts.app')

@section('content')
    <div class="container bg-white">
        <div class="row">
            <div class="col-md-12">
                <div class="h1">LARABLOG</div>
                <div class="h5 font-italic pl-md-3 text-monospace">Самое интересное из мира хуйнянейм.</div>
            </div>
        </div>
        @if($featuredTopic)
            <div class="row py-md-4">
                <div class="col-md-12">
                    <div class="h2">Рекомендовано</div>
                    <div class="card bg-dark overflow-hidden" style="height: 200px; background: url({{ $featuredTopic->image }}) no-repeat center/cover;">
                        <a href="{{ route('topics.show', $featuredTopic) }}">
                            <div style="background-color: rgba(0, 0, 0, 0.4);" class="card-img-overlay text-white">
                                <h4 class="card-title">{{ $featuredTopic->category->title }} / {{ $featuredTopic->title }}</h4>
                                <p class="card-text">{{ $featuredTopic->description }}</p>
                                <p class="card-text">
                                    {{ $featuredTopic->created_at->diffForHumans() }} by {{ $featuredTopic->author->name }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        @if($lastTopic)
        <div class="row py-md-4">
            <div class="col-md-12">
                <div class="h2">Свежайшая</div>
                    <div class="card bg-dark overflow-hidden" style="height: 200px; background: url({{ $lastTopic->image }}) no-repeat center/cover;">
                        <a href="{{ route('topics.show', $lastTopic) }}">
                        <div style="background-color: rgba(0, 0, 0, 0.4);" class="card-img-overlay text-white">
                            <h4 class="card-title">{{ $lastTopic->category->title }} / {{ $lastTopic->title }}</h4>
                            <p class="card-text">{{ $lastTopic->description }}</p>
                            <p class="card-text">
                                {{ $lastTopic->created_at->diffForHumans() }} by {{ $lastTopic->author->name }}
                            </p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        @else
            Постов нет
        @endif
        @if($updatedTopic)
        <div class="row py-md-4">
            <div class="col-md-12">
                <div class="h2">Недавно обновлённая</div>
                    <div class="card bg-dark overflow-hidden" style="height: 200px; background: url({{ $updatedTopic->image }}) no-repeat center/cover;">
                        <a href="{{ route('topics.show', $updatedTopic) }}">
                        <div style="background-color: rgba(0, 0, 0, 0.4);" class="card-img-overlay text-white">
                            <h4 class="card-title">{{ $updatedTopic->category->title }} / {{ $updatedTopic->title }}</h4>
                            <p class="card-text">{{ $updatedTopic->description }}</p>
                            <p class="card-text">
                                Обновлено {{ $updatedTopic->updated_at->diffForHumans() }} by {{ $updatedTopic->author->name }}
                            </p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        </div>
@endsection
