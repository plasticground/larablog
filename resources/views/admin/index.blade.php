@extends('layouts.app')

@section('content')
    <div class="container container-fluid bg-white p-md-3">
        <div class="row">
            <div class="col-md-2">
                <div class="h4 text-center bg-success">
                    Админка
                </div>
                <div class="p-1 text-center">
                    <div class="card-img">
                        <img class="card-img img-thumbnail overflow-hidden rounded-circle" style="height: 150px; width: 150px;" src="{{ auth()->user()->avatar }}">
                        <p class="h5">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 btn-group-vertical">
                        <a class="btn btn-outline-dark" href="{{ route('admin.topics') }}">Темы</a>
                        <a class="btn btn-outline-dark" href="{{ route('categories.index') }}">Категории</a>
                        <a class="btn btn-outline-dark" href="{{ route('tags.index') }}">Теги</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                @yield('adminContent')
            </div>
        </div>
    </div>
@endsection
