@extends('layouts.app')

@section('content')

    <div class="container container-md">
        <form enctype="multipart/form-data" method="post" action="{{ route('topics.update', $topic) }}">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" name="title" value="{{ old('title', $topic->title) }}" class="form-control" id="title">
                @error('title')
                <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" class="form-control" id="description">{{ old('description', $topic->description) }}</textarea>
                @error('description')
                <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="body">Содержание</label>
                <textarea name="body" class="form-control" id="body">{!! old('body', $topic->body) !!}</textarea>
                @error('body')
                <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="imageFile">Загрузить изображение</label>
                <input name="image" type="file" class="form-control-file" id="imageFile">
                @error('image')
                <small class="form-text text-muted">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@push('styles')

@endpush

@push('scripts')
    <script>
        $('#body').summernote({
            height: 500
        });
    </script>
@endpush

