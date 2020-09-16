@extends('admin.index')

@section('adminContent')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if(!$tags->first())
        Нет тегов
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('tags.edit', [$tag, 'orderby' => 'id']) }}">id</a>
                </th>
                <th scope="col">
                    <a href="{{ route('tags.edit', [$tag, 'orderby' => 'title']) }}">Тег</a>
                </th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tagShow)
                <tr>
                    <th scope="row">{{ $tagShow->id }}</th>
                    <td>{{ $tagShow->title }}</td>
                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('tags.edit', $tagShow) }}">&#9998;</a>
                        <form class="d-md-inline" method="post" action="{{ route('tags.destroy', $tagShow) }}">
                            @method('DELETE')
                            @csrf
                            <button onclick="return confirm('Подтвердите удаление');" value="{{ $tagShow }}" type="submit" class="btn btn-danger">
                                &#10008;
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ route('tags.update', $tag) }}">
                @method('PUT')
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-sm-3 my-1">
                        <label class="sr-only" for="title">Изменить тег</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $tag->title) }}">
                        @error('title')
                        <small class="form-text text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-primary">Изменить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row my-md-3">
        <div class="col-md-12">
            {{ $tags->appends(request()->all())->links() }}
        </div>
    </div>
@endsection
