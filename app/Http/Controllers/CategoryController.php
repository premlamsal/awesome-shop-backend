<?php

namespace App\Http\Controllers;
use App\Http\Resources\Category as CategoryResource;
use App\Category as Category;
use App\User;
use Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        // return CategoryResource::collection(Category::get());
        $Category = Category::with('childs')->paginate(8);
        return CategoryResource::collection($Category);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name'        => 'required|string|max:100',

        ]);

        $category = new Category();

        $category->name = $request->input('name');

        $category->parent_id = $request->input('parent_id');

        $category->slug = preg_replace('/\s+/', '-', strtolower($request->input('name')));

        if ($category->save()) {
            return response()->json(['message' => 'You have successfully added the information.', 'status' => 'success']);
        } else {
            return response()->json(['message' => 'Opps! My Back got cracked while working in Database', 'status' => 'error']);
        }

    }

    public function show($id)
    {

        $category = Category::where('id', $id)->first();

        if ($category) {
            return response()->json([
                'category' => $category,
                'status'   => 'success',
            ]);
        } else {
            return response()->json(['message' => 'Opps! My Back got cracked while working in Database', 'status' => 'error']);
        }

    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'name'        => 'required|string|max:100',
        ]);


        $id = $request->input('id');

        $category = Category::where('id', $id)->first();

        $category->name = $request->input('name');

        $category->parent_id = $request->input('parent_id');

        $category->slug = preg_replace('/\s+/', '-', strtolower($request->input('name')));


        if ($category->save()) {
            return response()->json([
                'message'    => "Record Updated successfully",
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'message'    => 'Error Updating Data',
                'status' => 'error',
            ]);
        }
    }

    public function destroy($id)
    {

        $category = Category::where('id', $id)->first();

        if ($category->delete()) {
            return response()->json([
                'message'    => 'successfully Deleted',
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'message'    => 'Error while deleting data',
                'status' => 'error',
            ]);
        }
    }

    public function searchCategories(Request $request)
    {

        $searchKey = $request->input('searchQuery');

        if ($searchKey != '') {
            return CategoryResource::collection(Category::where('name', 'like', '%' . $searchKey . '%')->paginate(8));
        } else {
            return response()->json([
                'message'    => 'Error while retriving Categories. No Data Supplied as key.',
                'status' => 'error',
            ]);
        }
    }
}
