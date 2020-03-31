<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';
    protected $fillable = ['title', 'description'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
//    public function ingredients()
//    {
//
////        return $this->belongsToMany(Ingredient::class)->withPivot('price');
////        return $this->belongsToMany('App\Recipe', 'recipe_ingredient', 'ingredient_id', 'recipe_id')
////            ->withPivot(['amount', 'ingredient_id']);
//
//        return $this->belongsToMany(Recipe::class, 'recipe_ingredient',  'ingredient_id')
////            ->using(Ingredient::class)
////            ->as('ingredient')
//            ->withPivot(['amount', 'ingredient_id']);
//    }
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient', 'recipe_id')->withPivot('amount');
    }


}
