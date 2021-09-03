<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    
    public function createCategory(CreateCategoryRequest $request){
        
        $validated = $request->validated();

        $unique_id = $this->createUniqueToken('categories', 'unique_id');
        $user_id = auth()->user()->unique_id;
        
        try {
            Category::create(array_merge($validated, [
                'unique_id' => $unique_id,
                'user_id' => $user_id]));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $title = $request->category_title;
        return redirect()->back()->with('success', "$title category has been created");        
    }  
    
    public function deleteCategory($id){
        if ($category = Category::find($id)) {
            $category->delete();
        }else{
            return redirect()->back()->with('error', "Category does not Exist");
        }
        return redirect()->back()->with('success', "Category Deleted");
    }

    public function suspendCategory($id){
        if ($category = Category::find($id)) {
            $category->status = !$category->status;
            $category->save();
        }else{
            return redirect()->back()->with('error', "Category does not Exist");
        }
        $message = $category->status ? 'Restored' : 'Suspended';
        return redirect()->back()->with('success', "Category Suspended");
    }

}
