<?php

namespace App\Http\Controllers;

use App\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ingredients = Ingredient::all();
        return view('ingredient.index', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ingredient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|unique:ingredient|max:255',
        ]);
        $ingredient = new Ingredient([
            'title' => $request->get('title'),
        ]);
        $ingredient->save();
        return redirect('/ingredients')->with('success', 'Ингредиент сохранен!');

    }

    public function storeAjax(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title'=>'required|unique:ingredient|max:255',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $ingredient = new Ingredient([
            'title' => $request->get('title'),
        ]);
        $ingredient->save();
        return response()->json([
            'ingredient' => $ingredient,
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ingredient = Ingredient::find($id);
        return view('ingredient.edit', compact('ingredient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required',

        ]);

        $ingredient = Ingredient::find($id);
        $ingredient->title = $request->get('title');
        $ingredient->save();
        return redirect('/ingredients')->with('success', 'Ингредиент обнавлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ingredient = Ingredient::find($id);
        $ingredient->delete();
        return redirect('/ingredients')->with('success', 'Ингредиент удален!');
    }
}
