<?php

namespace App\Http\Controllers;

use App\Book;
use App\Esewa;
use App\Khalti;
use App\Order;
use Auth;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    public function verifyKhalti(Request $request)
    {

        $khalti = json_decode($request->input('khalti'), true);
        $cart = json_decode($request->input('cart'), true);

        $khalti_params_product_identity = explode("-", $khalti['product_identity']); //will split string to array by "-"
        $khalti_params_product_identity = array_slice($khalti_params_product_identity, 2); //will igonore array from 2
        $khalti_params_product_identity = implode("-", $khalti_params_product_identity);

        $khalti_params_amount = $khalti['amount'] / 100.00; //converting paisa to rs
        $khalti_params_mobile = $khalti['mobile'];
        $khalti_params_pre_token = $khalti['token'];

        $timeStamp = time();

        foreach ($cart as $temp) {

            $cart_book_id = $temp['bookId'];
            $cart_book_quantity = $temp['bookQuantity'];

            $book = Book::where('id', $cart_book_id);
            $book_price = $book->value('price');
            $book_discount = $book->value('discount');
            // $book_quantity = $book->value('quantity');
            $book_net_price = $book_price - $book_discount;
            $line_total = $cart_book_quantity * $book_net_price;
            $this->grand_total = $this->grand_total + $line_total;
            if ($this->books_id == "") {
                $this->books_id = $book->value('id');
            } else {
                $this->books_id = $this->books_id . "-" . $book->value('id'); //concat
            }
        } //end of for each

        $user_id = Auth::user()->id;

        if ($this->grand_total == $khalti_params_amount && $this->books_id == $khalti_params_product_identity) {

            //before verification for reference purposes
            $khalti = new Khalti;
            $khalti->user_id = $user_id;
            $khalti->mobile = $khalti_params_mobile;
            $khalti->amount = $khalti_params_amount;
            $khalti->pre_token = $khalti_params_pre_token;
            $khalti->product_identity = $khalti['product_identity'];
            $khalti->status = 0;
            $khalti->verified_token = "null";
            $khalti->save();

            if ($khalti) {
                $insertID = $khalti->id; //get recent inserted data id;
                //now everything is okay for verification process
                //hit api for verification
                $args = http_build_query(array(
                    'token' => $khalti_params_pre_token,
                    'amount' => ($khalti_params_amount) * 100,
                ));
                $url = "https://khalti.com/api/v2/payment/verify/";
                # Make the call using API.
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $headers = ['Authorization: Key ' . env('KHALTI_TEST_SECRET', '')];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                // Response
                $response = curl_exec($ch);
                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                $token = json_decode($response, true);

                if (isset($token['idx']) && $status_code == 200) {

                    //$message="Don't Worry! Everything Fine";
                    $message = $token['idx'];

                    //updating previous khalti table data with success status and verified_token
                    $khaltiUpdate = Khalti::find($insertID);
                    $khaltiUpdate->status = 1;
                    $khaltiUpdate->verified_token = $token['idx'];

                    if ($khaltiUpdate->save()) {

                        // inserting into the mybook table for the purchased entry for book

                        $Order = new Order;
                        $Order->user_id = Auth::user()->id;
                        $Order->trans_idx = $khalti_params_pre_token;
                        $Order->status = 'pending';
                        $Order->save();

                        if ($Order) {
                            return response()->json(['msg' => "You have successfuly bought book"], 200);
                        }
                    } else {
                        return response()->json("Failed while purchasing book", 503);
                    }
                } else {

                    return response()->json($response, 503);
                }
            } else {
                return response()->json("Some error occured", 500);
            }
        } else {
            return response(['msg' => 'Error while verifying payment. Contact web admin for more #err40001'], 503);
        }
    }

    public function verifyEsewa(Request $request)
    {
        $esewa = json_decode($request->input('esewa'), true);
        $oid = $esewa['oid'];
        $refId = $esewa['refId'];
        $amt = $esewa['amt'];

        $order_db = Order::findOrFail($oid);

        $timeStamp = time();

        if ($order_db->grand_total == $amt && $order_db->id == $oid) {

            //before verification for reference purposes
            $Esewa = new Esewa;
            $Esewa->user_id = Auth::user()->id;
            $Esewa->amt = $amt;
            $Esewa->refId = $refId;
            $Esewa->oid = $oid;
            $Esewa->status = 0; //will set to 1 if the transaction verified
            $Esewa->save();

            if ($Esewa) {

                $insertID = $Esewa->id; //picking the inserted data id for updating row later on after verification process

                //verification process starts
                $url = env('ESEWA_VERIFY_URL', '');
                $data = [
                    'amt' => $amt,
                    'rid' => $refId,
                    'pid' => $oid, //now already compared oid and pid now sending pid with timestamp
                    'scd' => env('ESEWA_MERCHANT', 'EPAYTEST'),
                ];

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                curl_close($curl);

                $insertID = $Esewa->id; //picking the inserted data id for updating row later on after verification process

                $verification_response = strtoupper(trim(strip_tags($response)));
                // print_r($data);
                // return response($verification_response);

                if ('SUCCESS' == $verification_response) {
                    // echo '<h2><strong>SUCCESS:</strong> Transaction is successful !!!</h2>';

                    // find the row of previously inserted data for update

                    $EsewaUpdate = Esewa::find($insertID);
                    $EsewaUpdate->status = 1;
                    if ($EsewaUpdate->save()) {
                        $order_db->trans_idx = $refId;
                        $order_db->status = 'pending';
                        if ($order_db->save()) {

                            return response(['msg' => 'You bought book successfully', 'status' => 'success'], 200);

                        } else {
                            return response(['msg' => 'Error While Adding Book.Contact admin for more information.'], 503);
                        }
                    } else {
                        return response(['msg' => 'Error While Updating Status of Book.Contact admin for more information..'], 503);
                    }
                } elseif ('FAILURE' == $verification_response) {

                    return response(['msg' => 'failed while verification.'], 503);
                } else {
                    return response(['msg' => 'No response from the verification server i.e ESEWA server might be offline or blocked the request.'], 503);
                }
            }
            //    return response(['msg'=>'Successfully verified payment'],201);

        } else {
            return response(['msg' => 'Error while verifying payment. Contact web admin for more #err30001'], 503);
        }
        // return response(['esewa'=>$esewa->oid],200);
    }

}
