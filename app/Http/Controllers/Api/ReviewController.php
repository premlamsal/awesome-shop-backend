<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Review;
use App\Http\Controllers\Controller;
use App\Http\Resource\Review as ReviewResource;
use Auth;
use App\Book;

class ReviewController extends Controller
{
    public function store(Request $request){

    	$this->validate($request,[

    		'title'=>'required|string|max:100',

    		'body' => 'required|string |max:1000',	

    		'rating'=> 'required|numeric',

    		'book_id'=>'required|numeric',

    	]);

    	$user_id=Auth::user()->id;

    	$product=Book::findOrFail($request->book_id);//find the product 

    	$review=new Review();//create review object 

    	$review->title=$request->title;	
    	
    	$review->body=$request->body;	
    	
    	$review->rating=$request->rating;	
    	
    	$review->user_id=$user_id;

    	$review->book_id=$request->book_id;

    	if($product->reviews()->save($review)){

    		return response(['msg'=>'Review posted successfully. Thanks for reviewing this product.','status'=>'success']);

    	}else{
    		return response(['msg'=>'Couldn\'t post review.','status'=>'error']);
    	}



    }
}
