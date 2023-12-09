<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expirationdate;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    use ApiTrait;
    public function index(){
        $medicine=Medicine::all();
        return $this->apiResponse($medicine,'the all medicines',200);
    }

    public function create(Request $request){

        $request->validate([
            'scientific_name'=>'required|string|max:25',
            'category_id'=>'required',
            'trade_name'=>'required|string|max:25|unique:medicines',
            'image'=>'required|image',
            'company'=>'required|string|max:25',
            'price'=>'required|max:25']);

        $imagePath = $request->file('image')->store('public/images');


        if(auth()->user()->role){
            $medicine = Medicine::create([
                'scientific_name' => $request->input('scientific_name'),
                'category_id' => $request->input('category_id'),
                'trade_name' => $request->input('trade_name'),
                'company' => $request->input('company'),
                'price' => $request->input('price'),
                'image' => $imagePath,
            ]);


            if ($medicine) {
                    return $this->apiResponse($medicine, 'the medicine inserted',201);
                }

            }

        return $this->apiResponse(null, 'the medicine didn\'t created you arent admin',404);

    }

    public function show_medicine($medicine_id){
        $medicine=Medicine::find($medicine_id);

        if($medicine){
            return $this->apiResponse($medicine,'the medicine found',200);
        }
        return $this->apiResponse($medicine,'the medicine not found',404);
    }

    public function show($category_id){
       $category=Category::with('medicines')->find($category_id);

        if($category){
            return $this->apiResponse($category,'the medicine found',200);
        }
        return $this->apiResponse(null,'there aren\'t any medicines in this category',404);
    }

    public function destroy($medicine_id)
    {
        if(auth()->user()->role){
            $medicine = Medicine::find($medicine_id);
            if (!$medicine) {
                return $this->apiResponse($medicine, 'the medicine not found',404);
            }
            $medicine->delete($medicine_id);
            if ($medicine) {
                return $this->apiResponse(null, 'the medicine deleted',200);
            }
        }

        return $this->apiResponse(null,'you aren\'t admin',403);
    }

    public function search($name){
        $medicine=Medicine::where('scientific_name','like','%'.$name.'%')->
        where('trade_name','like','%'.$name.'%')->
        where('trade_name','like','%'.$name.'%')->get();
        return $this->apiResponse($medicine,'this is your search result',200);
    }


        public function update(Request $request, $medicine_id)
    {
        $request->validate([
            'scientific_name'=>'required|string|max:25',
            'category_id'=>'required',
            'image'=>'required|image',
            'trade_name'=>'required|string|max:25|unique:medicines',
            'company'=>'required|string|max:25',
            'price'=>'required|max:25']);

        $imagePath = $request->file('image')->store('public/images');

        if(auth()->user()->role) {
            $medicine = Medicine::find($medicine_id);
            if (!$medicine) {
                return $this->apiResponse($medicine, 'the medicine not found', 404);
            }
            $medicine->update($request->all());
            if ($medicine) {
                return $this->apiResponse($medicine, 'the medicine updated', 201);
            }
        }

        return $this->apiResponse(null,'you aren\'t admin',403);
    }


}
