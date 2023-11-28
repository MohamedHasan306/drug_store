<?php

namespace App\Http\Controllers;

use App\Models\Expirationdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpirationdateController extends Controller
{
    use ApiTrait;

    public function create(Request $request){
        $request->validate([
            'medicine_id'=>'required',
            'expiration_date'=>'required|date',
            'production_date'=>'required|date',
            'quantity'=>'required'
        ]);

        $expiration_date=Expirationdate::create($request->only(
            'medicine_id',
            'expiration_date',
            'production_date',
            'quantity'
        ));

        if ($expiration_date) {
            return $this->apiResponse($expiration_date, 'the new Expiration_date inserted', 201);
        }

        return $this->apiResponse(null, 'the Expiration_date didn\'t created', 400);
    }

    public function quantity($id){
        return Expirationdate::where('medicine_id',$id)->sum('quantity');
    }



}
