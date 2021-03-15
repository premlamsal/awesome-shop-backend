<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Resources\User as UserResource;
use App\UserDetail;
use Carbon\Carbon;
use App\Transaction;
use App\Http\Resources\Transaction as TransactionResource;
use App\Http\Resources\Book as BookResource;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
	
    public function show(Request $request){

    	$user_id=Auth::user()->id;

    	$user=User::where('id',$user_id)->with('details')->get();

    	return UserResource::collection($user);
    }

    public function update(Request $request){

    	 $this->validate($request, [

            'firstname'     => 'required|max:55',

            'lastname'     => 'required|max:55',

            'details_phone'     => 'required|max:55',
            
            'details_address' => 'required',

            'details_esewa_id' => 'required',

            'details_khalti_id' => 'required',

            'details_about' => 'required',

            'details_postal' => 'required',

            'details_city' => 'required',

            'file'=>'image|mimes:jpeg,png,jpg,gif,svg|max:9048',

        ]);


        $baseurl=URL::to('/');

    	$user_id=Auth::user()->id;

    	$user=User::findOrFail($user_id);

    	$user->firstname=$request->firstname;

    	$user->lastname=$request->lastname;

    	$user->firstname=$request->firstname;

        if($request->file('file')!=null){

            $name = time().'.'.$request->file->getClientOriginalName();
                    $request->file->move(public_path().'/img/', $name);  
                    $filenam=$baseurl.'/img/'.$name;
            
            $user->image=$filenam;
       
        }

    	if($user->save()){

                $details=array();
    			$details['phone']=$request->details_phone;
                $details['address']=$request->details_address;
                $details['esewa_id']=$request->details_esewa_id;
                $details['khalti_id']=$request->details_khalti_id;
                $details['khalti_id']=$request->details_khalti_id;
                $details['about']=$request->details_about;
                $details['postal']=$request->details_postal;
                $details['city']=$request->details_city;
                $details['created_at']=$request->details_created_at;
                $details['updated_at']=$request->details_updated_at;
    			
    			 if($user->details()->get()->isEmpty()){

	    		   $details['created_at']=Carbon::now()->toDateTimeString();

		    		if($user->details()->create($details)){
		    	    	
		    			return UserResource::collection(User::where('id',$user_id)->with('details')->get());
		    		}
	    	
    			}
    			else{

    			    $details['created_at']=Carbon::parse($details['created_at']);
	    		    $details['updated_at']=Carbon::now()->toDateTimeString();
		    		  
		    		  if($user->details()->update($details)){
		    	    
		    			return UserResource::collection(User::where('id',$user_id)->with('details')->get());
		    		 }
	    		
    			}
	    		
    		
    	}else{
 			
 			return response()->json(['msg'=>'Data Update failed','status'=>'failed']);
    	}
    }

    public function userTransaction(Request $request){

    	
    	$user_id=Auth::user()->id;

    	$user=User::where('id',$user_id)->with('transactions')->with('details')->get();

    	return UserResource::collection($user);
    }

    public function checkIfWithDrawRequested(){

         $user_id=Auth::user()->id;

    	$user=User::where('id',$user_id)->get();

    	if($user[0]->withDrawRequest==1){

    	   return response()->json(['msg'=>'Sorry ! You have previously requested WithDraw. You can only request withdraw once previous withdraw completed.','data'=>$user[0]->withDrawRequest]);

    	}
    	else{

    	   return response()->json(['msg'=>'No with Draw Requested','data'=>$user[0]->withDrawRequest]);
    	}
    }

    public function withDrawRequest(Request $request){

	    $user_id=Auth::user()->id;

    	$user=User::where('id',$user_id)->with('details')->get();

    	if($user[0]->balance>=$request->amount){

    		$transaction= new Transaction();

    		$transaction->action="With Draw";

    		$transaction->amount=$request->amount;

    		$transaction->user_id=$user_id;

    		$transaction->method=$request->method;

    		$transaction->custom_transaction_id=substr(md5(time()), 0, 16);

    		$transaction->status="pending";

    		if($transaction->save()){

    			return response()->json(['msg'=>'With Draw Requested','status'=>'success']);

    		}else{
    		
    			return response()->json(['msg'=>'Sorry! Transaction creation failed #code U004.','status'=>'error']);

    		}


    	}else{

    		return response()->json(['msg'=>'Sorry! You don\'t have enought balance #code U005.','status'=>'error']);
    	}

    }

    public function loadMyBooks(Request $request){

    	$user_id=Auth::user()->id;

    	$user=User::where('id',$user_id)->with('books')->get();

    	return BookResource::collection($user[0]->books);

    }
}
