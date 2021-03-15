<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Book;
use App\Http\Resources\Book as BookResource;
use App\Category;
use Illuminate\Support\Facades\URL;
use Auth;

class BookController extends Controller
{
    public function index()
    {
        return BookResource::collection(Book::paginate(8));
    }

    public function relatedBooks($slug){

    return BookResource::collection(Book::where('slug','!=',$slug)->paginate(8));    
    }

    public function show($id)
    {
        return BookResource::collection(Book::findOrFail($id));
    }

    public function getBookDetail($slug){

        $book=Book::where('slug',$slug)->with('category')->with('unit')->with('reviews.user')->get();

        $book[0]->book_star=$book[0]->reviews->avg('rating');

        return BookResource::collection($book);
        // return response($book);
    }

    //show all book by category slug
    public function browseByCategory($slug){

        $category= Category::where('slug',$slug);

        $category_id=$category->value('id');

        if($category_id!=null){
         
        return BookResource::collection(Book::where('category_id',$category_id)->with('category')->with('unit')->paginate(1));

        }

        else{
            
            return response(['msg'=>'opps I couldn\'t find any book of that category']);
        }
       
    }
    public function browseBySearchKey($key){

        return BookResource::collection(Book::where('name','LIKE','%' . $key . '%')->with('category')->with('unit')->paginate(1));
    }
    public function update(Request $request){

         $this->validate($request, [
              'files.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',
              'category'=>'required|numeric',  
              'quantity'=>'required|numeric',  
              'unit'=>'required|numeric',  
              'name'=>'required|string|max:200',
              'price'=>'required|numeric',
              'discount'=>'required|numeric',  
              'more_info'=>'required|string|max:1000',  
              'description'=>'required|string|max:1000',  
              'book_id'=>'required|numeric',  
        ]);

        $user_id=Auth::user()->id;

        $filenam=array();
        //will get base url of the application
        $baseurl=URL::to('/');
           
        $book=Book::findOrFail($request->book_id);

        if($request->hasFile('files')){

              foreach($request->file('files') as $file)
            {
                $name = time().'.'.$file->getClientOriginalName();
                $file->move(public_path().'/img/', $name);  
                $filenam[]=$baseurl.'/img/'.$name;
            }


         //encode filenames in json array to save in database
        $filenam=json_encode($filenam);

        $book->image=$filenam;
        
        $book->thumb=$filenam;

        }
          
        
        $book_name = strtolower($request->name);

        $book_slug = preg_replace('/\s+/', '-', $book_name);


        $book->category_id=$request->category_id;
        
        $book->name=$request->name;
        
        $book->price=$request->price;
        
        $book->discount=$request->discount;
        
        $book->description=$request->description;

        $book->quantity=$request->quantity;
        
        $book->category_id=$request->category;

        $book->unit_id=$request->unit;
       
        
        $book->user_id=$user_id;

        $book->more_info=$request->more_info;
        
        $book->custom_book_id=substr(md5(time()), 0, 16);
        
        $book->slug=$book_slug;



        if($book->save()){
        
            return response(['msg'=>'Book Updated Successfully','status'=>'success','data'=>$book]);

        }else{
            return response(['msg'=>'Error while updating book','status'=>'error']);
        }
        


    }
    public function checkStock($id){

        $book_quantity=Book::where('id',$id)->value('quantity');
        return response(['instock_quantity'=>$book_quantity]);
    }
    public function store(Request $request){


         $this->validate($request, [
              'files'=>'required',
              'files.*'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:9048',
              'category'=>'required|numeric',  
              'quantity'=>'required|numeric',  
              'unit'=>'required|numeric',  
              'name'=>'required|string|max:200',
              'price'=>'required|numeric',
              'discount'=>'required|numeric',  
              'location'=>'required|string|max:200',
              'more_info'=>'required|string|max:1000',  
              'description'=>'required|string|max:1000',  
              'highlights'=>'required|string|max:1000',  
        ]);

        $user_id=Auth::user()->id;

        $filenam=array();
        //will get base url of the application
        $baseurl=URL::to('/');
      
       
            foreach($request->file('files') as $file)
            {
                $name = time().'.'.$file->getClientOriginalName();
                $file->move(public_path().'/img/', $name);  
                $filenam[]=$baseurl.'/img/'.$name;
            }
         //encode filenames in json array to save in database
        $filenam=json_encode($filenam);
        
        $book_name = strtolower($request->name);

        $book_slug = preg_replace('/\s+/', '-', $book_name);

        $book=new Book();

        $book->category_id=$request->category_id;
        
        $book->name=$request->name;
        
        $book->price=$request->price;
        
        $book->discount=$request->discount;
        
        $book->description=$request->description;

        $book->quantity=$request->quantity;

        $book->location=$request->location;

        $book->highlights=$request->highlights;
        
        $book->category_id=$request->category;

        $book->unit_id=$request->unit;
        
        $book->image=$filenam;
        
        $book->thumb=$filenam;
        
        $book->user_id=$user_id;

        $book->more_info=$request->more_info;
        
        $book->custom_book_id=substr(md5(time()), 0, 16);
        
        $book->slug=$book_slug;



        if($book->save()){
        
            return response(['msg'=>'Book Upload Successfully','status'=>'success','data'=>$book]);

        }else{
            return response(['msg'=>'Error while uploading book','status'=>'error']);
        }
        

    }
}
