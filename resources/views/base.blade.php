<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Книга рецептов</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/recipe.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/recipe.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="logout-btn float-right">
    <a href="javascript:void" onclick="$('#logout-form').submit();">
        Выход
    </a>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<div class="row">
    <div class="col-md-4 left-column">
        <div class="row">
            <div class="left-link  col-md-12">
                <a  href="/recipes">Мои Рецепты</a>
            </div>
            <hr>
            <div class="left-link  col-md-12">
                <a  href="/ingredients">Мои Ингридиенты</a>
            </div>
        </div>
    </div>
    <div class="col-md-8 container">
        @yield('content')
    </div>
</div>

<div class="alert-danger-custom alert-danger">

</div>
<div class="alert-danger-custom alert-success">

</div>
</body>
</html>
