<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function order()
    {
        return $this->belongsTo('\App\Order', 'order_id', 'id');

    }
    protected $fillable = ['order_id', 'book_id','quantity', 'image','name','price','discount','tax', 'line_total'];

}

