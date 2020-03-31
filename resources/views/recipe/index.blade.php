@extends('base')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Список рецептов</h1>
            <a href="/recipes/create" class="btn-success">Создать рецепт</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>
                        @if($sort_order == 'ASC')
                            <a href="/recipes/?sort_order=DESC">Название UP</a>
                        @else
                            <a href="/recipes/?sort_order=ASC">Название Down</a>
                        @endif
                    </td>
                    <td colspan = 3>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($recipes as $recipe)
                    <tr>
                        <td>{{$recipe->id}}</td>
                        <td>{{$recipe->title}}</td>
                        <td>
                            <a href="{{ route('recipes.show',$recipe->id)}}" class="btn btn-primary">View</a>
                        </td>
                        <td>
                            <a href="{{ route('recipes.edit',$recipe->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form  action="{{ route('recipes.destroy', $recipe->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Вы действительно хотите удалить рецепт?')" class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

