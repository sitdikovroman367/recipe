@extends('base')

@section('content')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1>Добавление Ингредиента</h1>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                <form method="post" action="{{ route('ingredients.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Название:</label>
                        <input type="text" class="form-control" name="title"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
