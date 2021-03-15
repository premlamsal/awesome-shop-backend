<?php

namespace App\Http\Controllers;
use App\Http\Resources\Unit as UnitResource;
use App\Unit;
use App\User;
use Auth;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        return UnitResource::collection(Unit::paginate(8));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'short_name' => 'required|string|max:10',

            'long_name'  => 'required|string|max:100',
        ]);

        $unit = new Unit();

        $unit->short_name = $request->input('short_name');

        $unit->long_name = $request->input('long_name');

        if ($unit->save()) {

            return response()->json([
                'msg'    => 'You have successfully added the information.',
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'msg'    => 'Opps! My Back got cracked while working in Database',
                'status' => 'error',
            ]);
        }

    }

    public function show($id)
    {

        $unit = Unit::where('id', $id)->first();

        return response()->json([
            'unit'   => $unit,
            'status' => 'success',
        ]);
    }

    public function update(Request $request)
    {



        $this->validate($request, [

            'short_name' => 'required|string|max:10',

            'long_name'  => 'required|string|max:100',
        ]);

        $id = $request->input('id');

        $unit = Unit::where('id', $id)->first();

        $unit->short_name = $request->input('short_name');

        $unit->long_name = $request->input('long_name');

        if ($unit->save()) {

            return response()->json([

                'msg'    => "Record Updated successfully",

                'status' => 'success',
            ]);
        } else {

            return response()->json([

                'msg'    => 'Error Updating Data',

                'status' => 'error',
            ]);
        }
    }

    public function destroy($id)
    {



        $unit = Unit::where('id', $id)->first();

        if ($unit->delete()) {

            return response()->json([

                'msg'    => 'successfully Deleted',

                'status' => 'success',
            ]);
        } else {
            return response()->json([

                'msg'    => 'Error while deleting data',

                'status' => 'error',
            ]);
        }
    }

    public function searchUnits(Request $request)
    {

        $searchKey = $request->input('searchQuery');
        if ($searchKey != '') {
            return UnitResource::collection(Unit::where('short_name', 'like', '%' . $searchKey . '%')->paginate(8));
        } else {
            return response()->json([
                'msg'    => 'Error while retriving Units. No Data Supplied as key.',
                'status' => 'error',
            ]);
        }
    }
}
