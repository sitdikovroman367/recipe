@extends('base')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <form method="post" action="{{ route('recipes.update', $recipe->id) }}">
        @method('PATCH')
        @csrf
        <div id="main-form">
            <div class="row">

                <div class="col-sm-8 offset-sm-2">
                    <h1>Редактирование Рецепта #{{ $recipe->id }} </h1>
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
                        <div class="form-group">
                            <label for="title">Название:</label><br>
                            <input type="text" required class="form-control" name="title" value="{{$recipe->title}}"/>
                        </div>

                        <div class="form-group">
                            <label for="description">Описание:</label><br>
                            <textarea required class="form-control" name="description">{{$recipe->description}}</textarea>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <div id="toAppend-block">
            <div class="d-flex justify-content-between">
                <div class="col">Ингридент</div>
                <div class="col">Количество</div>
            </div>
            @foreach($recipeIngredients as $Ringredient)
                <div class="row">
                    <div class="col form-group">
                        <select class="select-ingredient" required name="ingredient[]">
                            <option class="insert_after"></option>
                             <option selected value="{{$Ringredient->id}}">{{$Ringredient->title}}</option>
                        </select>
                    </div>
                    <div class="col form-group">
                        <input required name="amount[{{$Ringredient->id}}]" type="number" step="0.01" value="{{$Ringredient->pivot->amount}}" >
                    </div>
                    <a class="delete-rel" data-ingr-id="{{$Ringredient->id}}">Delete</a>
                </div>
            @endforeach
        </div>

        <div class="button-ingr-act">
            <button id="add-select-ingredient" class="btn btn-primary">Добавить</button>
            <div>
                <span>Нет в списке</span>
                <button id="buttonIngredientModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addIngredientModal">Создать новый ингредиент</button>
            </div>
        </div>
        <!-- Button trigger modal -->

        <hr>
        <button type="submit" class="btn-group-lg btn-success">Сохранить рецепт</button>
    </form>
    @foreach($recipeIngredients as $Ringredient)
        <form data-form-id="{{$Ringredient->id}}"  style="display:none;" action="/recipes/{{ $Ringredient->id}}/destroyRelation/" method="POST">
            <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
            @method('DELETE')
            @csrf
        </form>
    @endforeach
    <div class="modal" tabindex="-1" role="dialog" id="addIngredientModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавление ингредиента</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/storeAjax" id="addIngredForm">
                        <div class="form-group">
                            <label for="title">Название:</label>
                            <input  type="text" class="form-control" name="title" />
                        </div>
                        <input type="hidden" name="isAjax" value="1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="save-ingredient" type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row newItm" id="hidden-ingred-tmp" >
        <div class="col form-group">
            <select class="select-ingredient" required name="newIngredient[] ">
                <option class="insert_after"></option>
                @foreach($ingredientsAll as $ingredient)
                    @if(!in_array($ingredient->id, $selectedIds))
                        <option value="{{$ingredient->id}}">{{$ingredient->title}}</option>
                    @endif;
                @endforeach
            </select>
        </div>
        <div class="col form-group">
            <input required name="newAmount[]" type="number" step="0.01" value="" >
        </div>
        <a class="delete-newRel">Delete</a>
    </div>
@endsection
