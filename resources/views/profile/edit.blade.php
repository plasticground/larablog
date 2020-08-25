@extends('layouts.app')

@section('content')

    <div class="container container-fluid bg-white p-md-3">
        <div class="row">
            <div class="col-md-12">
                <div class="h4 text-center">Редактирование профиля</div>
                <p><small class="text-muted font-italic">Ваша карточка профиля: </small></p>
            </div>
        </div>
        <form enctype="multipart/form-data" method="post" action="{{ route('profile.update', $user) }}">
            @method('PUT')
            @csrf
        <div class="card col-md-12 shadow-sm">
            <div class="card-body p-1">
                <div class="row">
                    <div class="col-md-2 p-1 text-center">
                        <div class="card-img">
                            <img class="card-img img-thumbnail overflow-hidden rounded-circle" style="height: 150px; width: 150px;" src="{{ $user->avatar }}">
                        </div>
                    </div>
                    <div class="col-md-10 p-1">
                        <blockquote class="blockquote mb-0">
                            <div class="form-group">
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" id="name">
                                @error('name')
                                <small class="form-text text-muted">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea name="description" class="form-control" id="description">{{ old('description', $user->description) }}</textarea>
                                @error('description')
                                <small class="form-text text-muted">{{ $message }}</small>
                                @enderror
                            </div>
                        </blockquote>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <input name="avatar" type="file" accept="image/*" class="form-control-file" id="avatar">
                            @error('avatar')
                            <small class="form-text text-muted">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 text-md-right">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
