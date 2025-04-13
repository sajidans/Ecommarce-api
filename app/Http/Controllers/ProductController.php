<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    
    public function index()
{
    $products = Cache::remember('all_products', now()->addMinutes(2), function () {
        return Product::with('variants', 'category', 'subcategory')->get();
    });

    

    return response()->json([
        'status' => true,
        'data' => $products
    ]);
}
    
    public function store(Request $request)
    {
   
     
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:products',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            //'variants' => 'required|array|min:1',
            'variants' => 'required|string' 
        ]);
    
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }
       
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
    
        
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'img_url' => asset('storage/app/public/'),
        ]);
    
       
        $variants = json_decode($request->variants, true);
    foreach ($variants as $variant) {
        Variant::create([
            'product_id' => $product->id,
            'name' => $variant['name'],
            'price' => $variant['price'],
            'stock' => $variant['stock']
        ]);
    }
    
      
        $productWithVariants = $product->load('variants');
        Cache::put('product_'.$product->id, $productWithVariants, now()->addHours(2));
    
        
        return response()->json([
            'status' => true,
            'message' => 'Product Added Successfully',
            'data' => $productWithVariants
        ], 201);
    }

    
    public function show($id)
    {
        if($id==null){
            return response()->json([
                'status' => false,
                'message' => 'Product ID is required'
            ], 422);
        }

        try {
            $product = Cache::remember('product_' . $id, now()->addMinutes(2), function () use ($id) {
                return Product::with(['variants', 'category', 'subcategory'])->find($id); // 👈 Not findOrFail
            });
            
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ], 404);
            }

    
            return response()->json([
                'status' => true,
                'message' => 'Product fetched successfully!',
                'data' => $product
            ], 200);
    
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    public function update(Request $request, $id)
{

    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|unique:products,name,' . $product->id,
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:sub_categories,id',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'variants' => 'required|string' // JSON string
    ]);
    
    
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()
        ], 422);
    }
    

    
    $imagePath = $product->image;
    if ($request->hasFile('image')) {
     
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        
        $imagePath = $request->file('image')->store('products', 'public');
    }

    
    $product->update([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'description' => $request->description,
        'price' => $request->price,
        'image' => $imagePath,
        'img_url' => asset('storage/' . $imagePath),
    ]);

    
    $product->variants()->delete();

    $variants = json_decode($request->variants, true);
    foreach ($variants as $variant) {
        Variant::create([
            'product_id' => $product->id,
            'name' => $variant['name'],
            'price' => $variant['price'],
            'stock' => $variant['stock']
        ]);
    }

   
    $productWithVariants = $product->load('variants');
    Cache::put('product_' . $product->id, $productWithVariants, now()->addMinutes(2));

    return response()->json([
        'status' => true,
        'message' => 'Product Updated Successfully',
        'data' => $productWithVariants
    ], 200);
}

public function destroy($id)
{
    if($id == null) {
        return response()->json([
            'status' => false,
            'message' => 'Product ID is required'
        ], 422);
    }
    $product = Product::with('variants')->find($id);

    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found.'
        ], 404);
    }

    $product->variants()->delete();

   
    if ($product->image && \Storage::disk('public')->exists($product->image)) {
        \Storage::disk('public')->delete($product->image);
    }

   
    $product->delete();

    
    Cache::forget('product_' . $id);

    return response()->json([
        'status' => true,
        'message' => 'Product Deleted Successfully.'
    ], 200);
}

}
