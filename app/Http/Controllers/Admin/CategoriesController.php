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
            return redirect('categories')->with('message', $e->getMessage());
        }

        $title = $request->category_title;
        return redirect('categories')->with('message', "$title category has been created");        
    }  
    
    public function deleteCategory($id){
        if ($category = Category::find($id)) {
            try {
                $category->delete();
                return redirect()->back()->with('message', "Category Deleted");
            } catch (Exception $e) {
                return redirect()->back()->with('message', $e->getMessage());
            }
        }else{
            return redirect()->back()->with('message', "Category does not Exist");
        }
    }

    public function suspendCategory($id){
        if ($category = Category::find($id)) {
            try {
                $category->status = false;
                $category->save();
                
                return redirect()->back()->with('message', "Category Deleted");
            } catch (Exception $e) {
                return redirect()->back()->with('message', $e->getMessage());
            }
        }else{
            return redirect()->back()->with('message', "Category does not Exist");
        }
    }

}
