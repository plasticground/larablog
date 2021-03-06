@extends('admin.index')

@section('adminContent')
    <div class="h1">Теги</div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if(!$tags->first())
        Нет тегов, <a href="{{ route('tags.create') }}">Создать</a>?
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('tags.index', ['orderby' => 'id']) }}">id</a>
                </th>
                <th scope="col">
                    <a href="{{ route('tags.index', ['orderby' => 'title']) }}">Тег</a>
                </th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <th scope="row">{{ $tag->id }}</th>
                    <td>{{ $tag->title }}</td>
                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('tags.edit', $tag) }}">&#9998;</a>
                        <form class="d-md-inline" method="post" action="{{ route('tags.destroy', $tag) }}">
                            @method('DELETE')
                            @csrf
                            <button onclick="return confirm('Подтвердите удаление');" value="{{ $tag }}" type="submit" class="btn btn-danger">
                                &#10008;
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <div class="row my-md-3">
        <div class="col-md-12">
            <a class="btn btn-primary mb-md-3" href="{{ route('tags.create') }}">Создать</a>
            {{ $tags->appends(request()->all())->links() }}
        </div>
    </div>

@endsection
