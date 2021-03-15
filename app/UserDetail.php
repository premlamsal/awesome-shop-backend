<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{

	 protected $fillable = [
        'address', 'phone','city', 'postal','esewa_id','khalti_id','about','user_id'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
