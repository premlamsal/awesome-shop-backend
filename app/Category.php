<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
      public function childs()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id')->with('childs');
    }
}
