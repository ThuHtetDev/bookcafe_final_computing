<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function getCategory(){
        $categories = Category::all();
        return response()->json($categories);
    }

    public function saveCategory(Request $request){
        $this->validate($request, [
            'name' => 'required|max:191',
        ]);
        $cat_name = $request->name;
        $newCat = new Category;
        $newCat->name = $cat_name;
        $newCat->is_active = '1';
        $newCat->save();
        return response()->json(['message' => 'New Category is successfully saved']);
    }
}
