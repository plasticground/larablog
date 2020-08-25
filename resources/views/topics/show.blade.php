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
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 m-md-3">
                    <img class="img-thumbnail w-50 float-left  p-md-3" src="{{ $topic->image }}" alt="">
                    <blockquote class="blockquote">
                        {!! $topic->body !!}
                    </blockquote>
                </div>
            </div>
        </div>
        @auth
            @if($topic->author->is(auth()->user()))
                <div class="row mt-3 float-md-right">
                    <div class="col-md-12">
                        <a class="btn btn-primary" href="{{ route('topics.edit', $topic) }}">Edit</a>
                        <form style="display: inline" method="post" action="{{ route('topics.destroy', $topic) }}">
                            @method('DELETE')
                            @csrf
                            <button value="{{ $topic }}" type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

            @endif
        @endguest
    </div>

@endsection
