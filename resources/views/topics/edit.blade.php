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
            <div class="row form-group">
                <div class="col-md-3">
                    <label for="category">Категория</label>
                    <select name="category" id="category" value="{{ old('category') }}" class="form-control" placeholder="Выберите категорию">
                        @foreach($categories as $category)
                            <option>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9">
                    <label for="tags">Теги</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags', $topic->tags->implode('title', ',')) }}" class="form-control" placeholder="Укажите теги">
                </div>
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
            <div class="col-md-12 form-check-inline">
                <input class="form-check-input" type="checkbox" id="featured" name="featured">
                <label class="form-check-label pr-md-3" for="featured">Рекомендовать</label>
                <input class="form-check-input" type="radio" id="publish" name="status" value="1">
                <label class="form-check-label pr-md-3" for="publish">Опубликовать</label>
                <input class="form-check-input" type="radio" id="draft" name="status" value="0" checked>
                <label class="form-check-label pr-md-3" for="draft">Черновик</label>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
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
    <script>
        var tags = new Bloodhound({
            datumTokenizer: function(d) { return  Bloodhound.tokenizers.whitespace(d.name); },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: [
                    @foreach($tags as $tag)
                {name: '{{ $tag->title }}'},
                @endforeach
            ]
        });

        tags.initialize();

        $('#tags').tagsinput({
            maxChars: 16,
            confirmKeys: [13, 32, 44],
            maxTags: 8,
            typeaheadjs: {
                name: 'tags',
                displayKey: 'name',
                valueKey: 'name',
                source: tags.ttAdapter()
            }
        });
    </script>
@endpush

