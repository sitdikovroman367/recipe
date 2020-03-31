@extends('base')
@if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Ингредиенты</h1>
            <div>
                <a style="margin: 19px;" href="{{ route('ingredients.create')}}" class="btn btn-primary">Добаление ингредиента</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Меню</td>
                        <td colspan = 2>Действия</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ingredients as $ingredient)
                        <tr>
                            <td>{{$ingredient->title}}</td>
                            <td>
                                <a href="{{ route('ingredients.edit',$ingredient->id)}}" class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('ingredients.destroy', $ingredient->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Вы действительно хотите удалить ингредиент?')" class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        <div>
    </div>
@endsection
