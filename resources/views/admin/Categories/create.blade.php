@extends('admin.index')

@section('adminContent')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if(!$categories->first())
        Нет категорий
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('categories.create', ['orderby' => 'id']) }}">id</a>
                </th>
                <th scope="col">
                    <a href="{{ route('categories.create', ['orderby' => 'title']) }}">Категория</a>
                </th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td>{{ $category->title }}</td>
                    <td class="text-right">
                        <a class="btn btn-primary" href="{{ route('categories.edit', $category) }}">&#9998;</a>
                        <form class="d-md-inline" method="post" action="{{ route('categories.destroy', $category) }}">
                            @method('DELETE')
                            @csrf
                            <button onclick="return confirm('Подтвердите удаление');" value="{{ $category }}" type="submit" class="btn btn-danger">
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
            <form method="post" action="{{ route('categories.store') }}">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-sm-3 my-1">
                        <label class="sr-only" for="title">Создать категорию</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Новая категория" value="{{ old('title') }}">
                        @error('title')
                        <small class="form-text text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row my-md-3">
        <div class="col-md-12">
            {{ $categories->appends(request()->all())->links() }}
        </div>
    </div>
@endsection
