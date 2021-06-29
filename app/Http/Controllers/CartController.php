<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Auth;

class CartController extends Controller
{
    public $grand_total;
    public $books_id="ES";

    public function check(Request $request)
    {
    	$user_id=Auth::user()->id;

        foreach ($request->all() as $temp) {

            $cart_book_id = $temp['bookId'];
            $cart_book_quantity = $temp['bookQuantity'];

            $book = Book::where('id', $cart_book_id)->where('user_id','!=',$user_id);

            if($book->value('quantity')){
                if($this->books_id=="ES"){
                    $this->books_id = $this->books_id."-".time()."-".$book->value('id');//concat 
                }else{
                    $this->books_id = $this->books_id."-".$book->value('id');//concat 
                }
    
                $book_price = floatval($book->value('price'));
                $book_discount = $book->value('discount');
                $book_quantity = floatval($book->value('quantity')) ;
                $book_net_price = $book_price - $book_discount;
    
                if ($book_quantity >= $cart_book_quantity) {
    
                    $line_total = floatval($cart_book_quantity * $book_net_price);
    
                } else {
    
                    //cart quanity is higher than quantity in stock
                    return response(['msg'=>'error'],503);
                }
                $this->grand_total =floatval($this->grand_total + $line_total);
            }
           else{
               //you can't buy your own book
               return response(['msg'=>'You cannot buy own book. Remove your own book from cart and try agian.','data'=>'userbook'],503);
           }
        }

        // $temp_books_id=explode("-",$this->books_id);
        // $temp_books_id_slice=array_slice($temp_books_id,2);

        // print_r($temp_books_id_slice);


        return response(['amount'=>$this->grand_total,'books_id'=>$this->books_id],200);

    }
}
