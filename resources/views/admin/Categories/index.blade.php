@extends('admin.index')

@section('adminContent')
    <div class="h1">Категории</div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if(!$categories->first())
        Нет категорий, <a href="{{ route('categories.create') }}">Создать</a>?
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">
                    <a href="{{ route('categories.index', ['orderby' => 'id']) }}">id</a>
                </th>
                <th scope="col">
                    <a href="{{ route('categories.index', ['orderby' => 'title']) }}">Категория</a>
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
    <div class="row my-md-3">
        <div class="col-md-12">
            <a class="btn btn-primary mb-md-3" href="{{ route('categories.create') }}">Создать</a>
            {{ $categories->appends(request()->all())->links() }}
        </div>
    </div>

@endsection
