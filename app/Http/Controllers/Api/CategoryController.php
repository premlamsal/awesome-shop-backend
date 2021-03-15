<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
    public function index(){

    	$Category=Category::all();

    	return CategoryResource::collection($Category);
    }
    public function random(){

    	$Category=Category::where('parent_id',null)->inRandomOrder()->limit(5)->get();

    	return CategoryResource::collection($Category);
    }
    public function getCategoriesForMenu(){

        $Category = Category::WhereNull('parent_id')->with('childs')->get();
        return response()->json(['data'=>$Category]);
    
    }
}
