<?php

namespace App\Http\Controllers;

use App\Book;
use App\Transaction;
use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{
    public function info(){

        $customers=User::where('user_type','!=','admin')->count();
        $books=Book::all()->count();
        $transactions=Transaction::all()->count();
        
        return response(['customers'=>$customers,'books'=>$books,'transactions'=>$transactions]);
    }
}
