<?php

namespace App\Http\Controllers\api\v3;
use App\Model\DirectsellCategories;
use App\Model\DirectsellSubCategories;
use App\Model\Product_detail;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class DirectSellCategoryController extends Controller
{
    public function index()
    {
        $categories = DirectsellCategories::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'No records found',
                'status' => 'No Records',
            ]);
        }

        $categoryData = $categories->map(function ($category) {
            $imageUrl = null;
            if ($category->image) {
                $encodedFileName = rawurlencode($category->image);
                $imageUrl = asset('/public/storage/' . $encodedFileName);
            }

            return [
                'id' => $category->id,
                'name' => $category->name,
                'image_url' => $imageUrl,
            ];
        });

        return response()->json([
            'message' => 'Record Found Successfully',
            'status' => 'Success',
            'categories' => $categoryData,
        ]);
    }


    public function show($id)
    {
        $category = DirectsellCategories::find($id);
        return response()->json(['category' => $category]);
    }

    public function sub($id)
    {
        $subCategories = DirectsellSubCategories::where('category_id', $id)->get();

        if ($subCategories->isEmpty()) {
            return response()->json([
                'message' => 'No subcategories found for the given category ID',
                'status' => 'No Records',
            ]);
        }

        return response()->json([
            'message' => 'Subcategories retrieved successfully',
            'status' => 'Success',
            'total_record' => count($subCategories),
            'subCategories' => $subCategories,
        ]);
    }

    public function form()
    {
        $productDetails = Product_detail::all();
        return response()->json(['productDetails' => $productDetails]);
    }

    
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'button' => 'required',
                'sub_categories' => 'required|string',
                'product_identification' => 'required|string|max:255',
                'technical_data' => 'required|string',
                'your_desired_price' => 'required|numeric',
                'contact' => 'required|numeric',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'user_id' => 'required|numeric',
            ]);
    
            // Get the authenticated user's ID
            $user_id = $validatedData['user_id'];
            // Initialize the $images variable
            $images = [];
            // Check if there are uploaded images
            if ($files = $request->file('images')) {
                foreach ($files as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move('public/storage', $name);
                    $images[] = $name;
                }
            }
    
            // Your code to create the product and associate it with the user...
            
            $product = Product_detail::create([
                'button' => $validatedData['button'],
                'sub_categories' => $validatedData['sub_categories'],
                'product_identification' => $validatedData['product_identification'],
                'technical_data' => $validatedData['technical_data'],
                'your_desired_price' => $validatedData['your_desired_price'],
                'contact' => $validatedData['contact'],
                'images' => implode("|", $images),
                'user_id' => $user_id,  // Associate the product with the authenticated user
            ]);
    
            return response()->json([
                'status' => 'Success',
                'message' => 'Product added successfully.',
                'productDetail' => $product,
            ]);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Exception: ' . $e->getMessage());
        
            // Return an error response
            return response()->json([
                'status' => 'Error',
                'message' => 'Failed to add product. Please try again later.',
            ], 500);
        }
    }
}
