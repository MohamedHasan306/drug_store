<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    use ApiTrait;

    public function create(Request $request){

        $validator= $request->validate([
            'medicine_id'=>'required',
            'pharmacist_id'=>'required',
            'order_quantity'=>'required']);

        $expirationDateController = app(\App\Http\Controllers\ExpirationdateController::class);
        $all_quantity = $expirationDateController->quantity($request['medicine_id']);

        if ($all_quantity<$request['order_quantity']){
            return $this->apiResponse(null,'your order not available now ',400);
        }
        $order=Order::create(
            $request->only('medicine_id','pharmacist_id','order_quantity')
        );

        if ($order) {
            return $this->apiResponse($order, 'the order inserted', 201);
        }

        return $this->apiResponse(null, 'the order didn\'t created', 400);}

}
