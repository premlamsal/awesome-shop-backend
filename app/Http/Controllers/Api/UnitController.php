<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Unit;
use App\Http\Resources\Unit as UnitResource;

class UnitController extends Controller
{
    public function index(){

    	return UnitResource::collection(Unit::all());
    }
}
