<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
        $subCategories = SubCategory::with('category')->get();
        return response()->json(['status' => true, 'data' => $subCategories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|unique:sub_categories'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }
             
        $subCategory = SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
        ]);
        if (!$subCategory) {
            return response()->json(['status' => false, 'message' => 'SubCategory Creation Failed'], 500);
        }
        return response()->json(['status' => true, 'message' => 'SubCategory Created Successfully', 'data' => $subCategory]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if($id == NULL){
            return response()->json(['status' => false, 'message' => 'SubCategory ID is required'], 422);
        }
        $subCategory = SubCategory::with('category')->find($id);
        if (!$subCategory) {
            return response()->json(['status' => false, 'message' => 'SubCategory Not Found'], 404);
        }
        return response()->json(['status' => true, 'data' => $subCategory]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($id == NULL){
            return response()->json(['status' => false, 'message' => 'SubCategory ID is required'], 422);
        }
        $subCategory = SubCategory::with('category')->find($id);
        if (!$subCategory) {
            return response()->json(['status' => false, 'message' => 'SubCategory Not Found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|unique:sub_categories,name,' . $id
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }
        $subCategory = SubCategory::findOrFail($id);
        if (!$subCategory) {
            return response()->json(['status' => false, 'message' => 'SubCategory Not Found'], 404);
        }
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|unique:sub_categories,name,' . $id
        ]);
        $subCategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
        ]);
        

        return response()->json(['status' => true, 'message' => 'SubCategory Updated Successfully', 'data' => $subCategory]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($id == NULL){
            return response()->json(['status' => false, 'message' => 'SubCategory ID is required'], 422);
        }
        $subCategory = SubCategory::find($id);
        if (!$subCategory) {
            return response()->json(['status' => false, 'message' => 'SubCategory Not Found'], 404);
        }
   

        
        $subCategory->delete();

        return response()->json(['status' => true, 'message' => 'SubCategory Deleted Successfully']);

    }
}
