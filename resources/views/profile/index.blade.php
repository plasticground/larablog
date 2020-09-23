@extends('layouts.app')

@section('content')
    <div class="container container-fluid bg-white py-md-3">
        <div class="row">
            <div class="col-md-8">
                <div class="h1">
                    Список пользователей
                </div>
            </div>
            <div class="col-md-4">
                <form method="get" action="{{ route('profile.index') }}">
                    <div class="form-row">
                        <div class="col">
                            <input name="search" id="search" type="text" class="form-control" placeholder="'#id' или 'Имя'">
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="form-control btn btn-outline-dark">Найти</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">
                            <a href="{{ $request->fullUrlWithQuery(['orderby' => 'id']) }}">#</a>
                        </th>
                        <th scope="col">
                            <a href="{{ $request->fullUrlWithQuery(['orderby' => 'name']) }}">Пользователь</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($users->first() == null)
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    Пользователь не найден
                                </td>
                            </tr>
                        @endif
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>
                                    <a href="{{ route('profile.show', $user->id) }}">
                                        {{ $user->name }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 py-md-3">
                {{ $users->links() }}
                <a href="{{ $request->fullUrlWithQuery(['limit' => '5']) }}">5</a>
                <a href="{{ $request->fullUrlWithQuery(['limit' => '10']) }}">10</a>
                <a href="{{ $request->fullUrlWithQuery(['limit' => '25']) }}">25</a>
                <a href="{{ $request->fullUrlWithQuery(['limit' => '50']) }}">50</a>
            </div>
        </div>
@endsection
