<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Menu;
use Illuminate\Http\Request;


class MenuController extends Controller
{
    public function index()
    {
        $menus    = Menu::WhereNull('parent_id')->get();
        $allMenus = Menu::pluck('title', 'id');

        return view('menu.menuTreeview', compact('menus', 'allMenus'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        // $input=$request->all();
        // $input['parent_id']= empty($input['parent_id']) ? 0 : $input['parent_id'];
        // Menu::create($input);
        $menu        = new Menu();
        $menu->title = $request->input('title');
        $menu->isPage = 0;
        if ($request->input('parent_id')) {
            $menu->parent_id = $request->input('parent_id');
        }
        $menu->save();
        return back()->with('success', 'Menu added successfully.');

    }
    public function show()
    {
        // $menus = Menu::Where('parent_id','=',0)->get();
        $menus = Menu::WhereNull('parent_id')->get();
        return view('menu.dynamicMenu', compact('menus'));
    }

   
    public function show2()
    {
        // $menus = Menu::Where('parent_id','=',0)->get();
        $menus = Menu::WhereNull('parent_id')->with('childs')->get();
        return response()->json(['data'=>$menus]);
    }
}
