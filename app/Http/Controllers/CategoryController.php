<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiTrait;

    public function create(Request $request)
    {
        $request->validate( [
            'name' => 'required|string|max:25'
        ]);

        $category = Category::create($request->only('name'));

        if ($category) {
            return $this->apiResponse($category, 'the category inserted', 201);
        }

        return $this->apiResponse(null, 'the category didn\'t created', 400);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->apiResponse($category, 'the category not found', 404);
        }
        $category->delete($id);
        if ($category) {
            return $this->apiResponse(null, 'the category deleted', 200);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate( [
            'name' => 'required|string|max:25'
        ]);
        $category = Category::findOrFail($id);
        if (!$category) {
            return $this->apiResponse($category, 'the post not found', 404);
        }
        $category->update($request->only('name'));
        if ($category) {
            return $this->apiResponse($category, 'the post updated', 201);
        }
    }

    public function search($name){
        $medicine=Category::where('name','like','%'.$name.'%')->get();

        return $this->apiResponse($medicine,'this is your search result',200);
    }



}
