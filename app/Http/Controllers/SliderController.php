<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Slider;
use Auth;
use App\Http\Resources\Slider as SliderResource;

class SliderController extends Controller
{
    public function index()
    {
        $slides = Slider::with('user')->paginate(8);
        return SliderResource::collection($slides);
    }
    public function show($id)
    {
        $slider = Slider::where('id',$id)->get();

        return SliderResource::collection($slider);
    }
    public function store(Request $request)
    {

        $this->validate($request, [

            'heading'     => 'required|max:55',

            'link'     => 'required|max:155',

            'description'     => 'required|max:550',

            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',

        ]);

        $baseurl = URL::to('/');

        $slider = new Slider();
        $slider->heading = $request->heading;
        $slider->link = $request->link;
        $slider->description = $request->description;

        if ($request->file('file') != null) {

            $name = time() . '.' . $request->file->getClientOriginalName();
            $request->file->move(public_path() . '/img/', $name);
            $filenam = $baseurl . '/img/' . $name;

            $slider->image = $filenam;
        $slider->thumb = $filenam;

        }

        $slider->user_id = Auth::user()->id;

        if ($slider->save()) {
            return response(['message' => 'Slider Uploaded Successfully', 'status' => 'success']);
        }
    }
    public function update(Request $request)
    {

        $this->validate($request, [

            'heading'     => 'required|max:55',

            'link'     => 'required|max:155',

            'description'     => 'required|max:550',

            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:9048',

        ]);

        $baseurl = URL::to('/');
        $slider = Slider::findOrFail($request->id);
        $slider->heading = $request->heading;
        $slider->link = $request->link;
        $slider->description = $request->description;

        if ($request->file('file') != null) {

            $name = time() . '.' . $request->file->getClientOriginalName();
            $request->file->move(public_path() . '/img/', $name);
            $filenam = $baseurl . '/img/' . $name;

            $slider->image = $filenam;
        $slider->thumb = $filenam;

        }

        $slider->user_id = Auth::user()->id;

        if ($slider->save()) {
            return response(['message' => 'Slider Updated Successfully', 'status' => 'success']);
        }
    }

    public function delete($id){

        $slider=Slider::findOrFail($id);
        if($slider->delete()){
            return response(['message' => 'Slider removed Successfully', 'status' => 'success']);
        }
    }
}
