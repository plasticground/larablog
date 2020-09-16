@extends('admin.index')

@section('adminContent')
    <div class="row">
        <div class="col-md-6 h1">
            Темы
        </div>
        <div class="col-md-6">
            <form method="get" action="{{ route('admin.topics') }}">
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
    @if(!$topics->first())
        <div class="col-md-12">
            Нет тем, <a href="{{ route('topics.create') }}">Создать</a>?
        </div>
    @else
        <table class="table table-striped mw-100">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Тема</th>
                <th scope="col">Категория</th>
                <th scope="col">Теги</th>
                <th scope="col">Автор</th>
                <th scope="col">Дата</th>
                <th scope="col">Инструменты</th>
            </tr>
            </thead>
            <tbody>
            @foreach($topics as $topic)
                <tr>
                    <th scope="row">{{ $topic->id }}</th>
                    <td class="text-break" style="max-width: 12em ">
                        <a href="{{ route('topics.show', $topic) }}">{{ $topic->title }}</a>
                    </td>
                    <td class="text-break">{{ $topic->category->title }}</td>
                    <td class="text-break" style="max-width: 10em;">
                        {{ $topic->tags->implode('title', ', ') }}
                    </td>
                    <td>{{ $topic->author->name }}</td>
                    <td>
                        @if($topic->created_at != $topic->updated_at)
                            UPD: {{ $topic->updated_at->diffForHumans() }}
                        @else
                            {{ $topic->created_at->diffForHumans() }}
                        @endif
                        <br>
                        <small>{{ $topic->updated_at }}</small>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('topics.edit', $topic) }}">&#9998;</a>
                        <form class="d-md-inline" method="post" action="{{ route('topics.destroy', $topic) }}">
                            @method('DELETE')
                            @csrf
                            <button onclick="return confirm('Подтвердите удаление {{ $topic->title }}');" value="{{ $topic }}" type="submit" class="btn btn-danger">
                                &#10008;
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    </div>
    <div class="row my-3">
        <div class="col-md-12">
            <a class="btn btn-primary mb-md-3" href="{{ route('topics.create') }}">Создать</a>
            {{ $topics->appends(request()->all())->links() }}
        </div>
    </div>
@endsection
