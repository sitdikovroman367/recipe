<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use Illuminate\Http\Request;
use yii\web\View;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_order = $request->get('sort_order');
        if(!$sort_order) {
            $sort_order = 'ASC';
        }
        if($sort_order == 'ASC') {
            $recipes = Recipe::all()->sortBy("title");
        } else {
            $recipes = Recipe::all()->sortByDesc("title");
        }
        return view('recipe.index', [
                'recipes' => $recipes,
                'sort_order' => $request->get('sort_order')
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *вв
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ingredients = Ingredient::orderBy('created_at', 'ASC')->get();
        return view('recipe.create', [
            'ingredients' => $ingredients
        ]);
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
            'title'=>'required|unique:recipe|max:255',
            'description'=>'required|max:50000',
            'amount' => 'required',
            'ingredient' => 'required'
        ]);
        $amounts = $request->input('amount');
        $ingredientIDs = $request->input('ingredient');

        $recipe = new Recipe([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);
        $recipe->save();
        for ($i = 0; $i < count($ingredientIDs); $i++) {
            $recipe->ingredients()->attach((int)$ingredientIDs[$i], [
                'amount'=> $amounts[$i] ,
                'ingredient_id' => (int)$ingredientIDs[$i]
            ]);
        }
        return redirect('/recipes')->with('success', 'Рецепт сохранен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::find($id);
        $ingredients = $recipe->ingredients()->get();
        return view('recipe.view', [
           'recipe' => $recipe,
           'ingredients'=>$ingredients,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::find($id);
        $selectedIds = [];
        $ingredients = $recipe->ingredients()->get();

        foreach ($ingredients as $ingredient) {
            $selectedIds[] = $ingredient->id;
        }

        $ingredients = Ingredient::orderBy('created_at', 'ASC')->get();

//        dd( $recipe->ingredients()->get());
        return view('recipe.edit', [
            'recipe' => $recipe,
            'recipeIngredients' => $recipe->ingredients()->get(),
            'ingredientsAll' => $ingredients,
            'selectedIds' => $selectedIds
        ]);
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
        $recipe = Recipe::find($id);
        $syncArr = [];
        $amounts = $request->input('amount');
        $ingredientIDs = $request->input('ingredient');


        $newAmounts = $request->input('newAmount');
        $newIngredientIDs = $request->input('newIngredient');
//        dd($newIngredientIDs);
//        echo '<pre>';
//        print_r($newAmounts);
//        echo '<br>';
//        print_r($newIngredientIDs);
//        dd($ingredientIDs);
//        dd($amounts);
//        for ($i = 0; $i < count($ingredientIDs); $i++) {
//
//            $syncArr[(int)$ingredientIDs[$i]]['amount'] = $amounts[$i];
//
//        }
//        dd($syncArr);
        if($ingredientIDs) {
            foreach ($ingredientIDs as $ingId) {
                $syncArr[$ingId]['amount'] = $amounts[$ingId];
            }
            $recipe->ingredients()->sync($syncArr);
        }
//        dd($newIngredientIDs);
        if($newIngredientIDs) {
            for ($i = 0; $i < count($newIngredientIDs); $i++) {
                $recipe->ingredients()->attach((int)$newIngredientIDs[$i], [
                    'amount'=> $newAmounts[$i] ,
                    'ingredient_id' => (int)$newIngredientIDs[$i]
                ]);
            }
        }

        return redirect('/recipes/'.$id.'/edit')->with('success', 'Ингредиент обновлен!');
    }

    public function destroyRelation(Request $request, $id)
    {

        $recipe_id = (int)$request->get('recipe_id');
        $recipe = Recipe::find($recipe_id);
        $recipe->ingredients()->detach($id);
        $recipe->save();
        return redirect('/recipes/'.$recipe_id.'/edit')->with('success', 'Ингредиент удален!');

//        $supplier->products()->detach($product->id);
//        dd($id);
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Recipe::find($id)->delete();
        if ($res){
            $data=[
                'status'=>'1',
                'msg'=>'success'
            ];
        }else {
            $data = [
                'status' => '0',
                'msg' => 'fail'
            ];
        }
        return redirect('/recipes/')->with('success', 'Рецепт удален!');

        //
    }
    public function updateAmount(Request $request, $id) {
        $request->validate([
            'recipe_id' => 'required',
            'amount' => 'required_with:initial_page|integer|min:'. 1 .'|digits_between:1,1264'

        ]);

        $recipe_id = (int)$request->get('recipe_id');
        $recipe = Recipe::find($recipe_id);
        Recipe::find($recipe_id)->ingredients()->updateExistingPivot($id, ['amount'=>$request->get('amount')]);
//        $recipe->ingredients($id, array('amount' => $request->get('amount')[$id]), false);
        return redirect('/recipes/'.$recipe_id.'/')->with('success', 'Ингредиент обновлен!');
    }
}
