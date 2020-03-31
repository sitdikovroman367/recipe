@extends('base')
@if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@section('content')
    <div class="view-main row">
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
        <div class="col-sm-12">
            <h4>{{$recipe->title}}</h4> <a href="/recipes/{{$recipe->id}}/edit/">Edit</a>
        </div>
        <div class="col-sm-12">
            <p>{{$recipe->description}}</p>
        </div>
        <div class="col-sm-12">
            @foreach($ingredients as $Ringredient)
                <form  action="/recipes/{{ $Ringredient->id}}/updateAmount/" method="POST">
                    @method('POST')
                    @csrf
                    <div class="row">
                        <div class="col form-group">
                           <h4>{{$Ringredient->title}}</h4>
                        </div>
                        <div class="col form-group">
                            <input required name="amount" min="1" max="200000" type="number" step="0.01" value="{{$Ringredient->pivot->amount}}" >
                        </div>
                        <div class="col form-group">
                            <button type="submit" class="btn-success">Ок</button>
                        </div>
                        <hr>
                    </div>
                    <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
                </form>
            @endforeach
        </div>
    </div>
@endsection
