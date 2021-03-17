<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $grand_total;
    public $books_id="ES";

    public function check(Request $request)
    {

        foreach ($request->all() as $temp) {

            $cart_book_id = $temp['bookId'];
            $cart_book_quantity = $temp['bookQuantity'];

            $book = Book::where('id', $cart_book_id);
            
            if($this->books_id=="ES"){
                $this->books_id = $this->books_id."-".time()."-".$book->value('id');//concat 
            }else{
                $this->books_id = $this->books_id."-".$book->value('id');//concat 
            }

            $book_price = $book->value('price');
            $book_discount = $book->value('discount');
            $book_quantity = $book->value('quantity');
            $book_net_price = $book_price - $book_discount;

            if ($book_quantity >= $cart_book_quantity) {

                $line_total = $cart_book_quantity * $book_net_price;

            } else {

                //cart quanity is higher than quantity in stock
            }
            $this->grand_total = $this->grand_total + $line_total;
        }

        // $temp_books_id=explode("-",$this->books_id);
        // $temp_books_id_slice=array_slice($temp_books_id,2);

        // print_r($temp_books_id_slice);


        return response(['amount'=>$this->grand_total,'books_id'=>$this->books_id],200);

    }
}
