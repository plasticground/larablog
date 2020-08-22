@extends('layouts.app')

@section('content')

    <div class="container container-md">
        <form enctype="multipart/form-data" method="post" action="{{ route('topics.store') }}">
            @csrf
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" id="title">
                @error('title')
                <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                @error('description')
                <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="body">Содержание</label>
                <textarea name="body" class="form-control" id="body">{{ old('body') }}</textarea>
                @error('body')
                <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="imageFile">Загрузить изображение</label>
                <input name="image" type="file" class="form-control-file" id="imageFile">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        $('#body').summernote({
            placeholder: 'Hello Bootstrap 4',
            tabsize: 2,
            height: 500
        });
    </script>
@endpush
