@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Имя пользователя" aria-label="Имя пользователя" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
    </div>
@endsection
