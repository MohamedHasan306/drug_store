<?php

namespace App\Http\Controllers;

trait ApiTrait
{
    public  function apiResponse($data,$message,$statue){
        $response=[
            'data'=>$data,
            'message'=>$message,
        ];
        return response($response,$statue);
    }

}
