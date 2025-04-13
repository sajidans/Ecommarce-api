<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('subCategories')->get();
        return response()->json(['status' => true, 'data' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }
    
        $category = Category::create([
            'name' => $request->name,
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if($id == NULL){
            return response()->json(['status' => false, 'message' => 'Category ID is required'], 422);

        }
        $category = Category::with('subCategories')->find($id);
        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category  id Not Found'
            ], 404);
        }
        return response()->json(['status' => true, 'data' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
    
        if($id == NULL){
            return response()->json(['status' => false, 'message' => 'Category ID is required'], 422);

        }
        $category = Category::findOrFail($id);
        if (!$category) {
            return response()->json(['status' => false, 'message' => 'Category Not Found'], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $id
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        } 
        $category->update([
            'name' => $request->name,
        ]);

        return response()->json(['status' => true, 'message' => 'Category Updated Successfully', 'data' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id == NULL){
            return response()->json(['status' => false, 'message' => 'Category ID is required'], 422);

        }
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['status' => false, 'message' => 'Category Not Found'], 404);
        }
        
        $category->delete();

        return response()->json(['status' => true, 'message' => 'Category Deleted Successfully']);
    }
    
}
