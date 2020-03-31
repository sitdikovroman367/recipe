@extends('base')
@if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1>Обновить ингредиент</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            <form method="post" action="{{ route('ingredients.update', $ingredient->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="first_name">Название</label>
                    <input type="text" class="form-control" name="title" value={{ $ingredient->title }} />
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
@endsection
