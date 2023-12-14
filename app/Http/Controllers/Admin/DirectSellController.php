<?php

namespace App\Http\Controllers\Admin;

use App\Model\DirectsellCategories;
use App\Model\DirectsellSubCategories;
use App\Model\Product_detail;
use App\Http\Controllers\Controller;
use App\CPU\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DirectSellController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product_detail::query()
            ->when($search, function ($query) use ($search) {
                $query->where('button', 'like', '%' . $search . '%')
                    ->orWhere('product_identification', 'like', '%' . $search . '%')
                    ->orWhere('technical_data', 'like', '%' . $search . '%')
                    ->orWhere('your_desired_price', 'like', '%' . $search . '%');
            })->latest()
              ->paginate(10);

        return view('admin-views.direct-sell.list', compact('products'));
    }


    public function edit(Product_detail $product)
    {
        return view('admin-views.direct-sell.edit', compact('product'));
    }

    public function category()
    {
        return view('admin-views.direct-sell.category');
    }

    public function storecate(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'subcategories' => 'required',
        ]);

        try {
            // Handle the main category image
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $d_path = public_path() . '/storage';
                $file->move($d_path, $filename);
            }

            // Save the main category in the database
            $directSellCategory = DirectsellCategories::create([
                'name' => $request->input('name'),
                'image' => $filename,
            ]);

            // Handle subcategories
            if ($request->has('subcategories')) {
                foreach ($request->input('subcategories') as $subcategoryName) {
                    // Save subcategory in the database
                    $subcategory = DirectsellSubCategories::create([
                        'category_id' => $directSellCategory->id,
                        'name' => $subcategoryName,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Failed to create category.');
        }
    }

    public function showcate()
    {
        $categories = DirectsellCategories::with('subcategories')->get()->paginate(10);
        return view('admin-views.direct-sell.showcate', compact('categories'));
    }

    public function editcate($id)
    {
        $category = DirectsellCategories::findOrFail($id);
        return view('admin-views.direct-sell.editcate', compact('category'));
    }

    public function updatecate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'sometimes|file|mimes:jpeg,png,jpg,gif|max:2048',
            'subcategories' => 'required',
        ]);

        try {
            $directSellCategory = DirectsellCategories::findOrFail($id);

            // Handle the main category image
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $d_path = public_path() . '/storage';
                $file->move($d_path, $filename);
                $directSellCategory->image = $filename;
            }

            // Update the main category in the database
            $directSellCategory->name = $request->input('name');
            $directSellCategory->save();

            // Handle subcategories
            $directSellCategory->subcategories()->delete(); // Delete existing subcategories
            foreach ($request->input('subcategories') as $subcategoryName) {
                // Save subcategory in the database
                $subcategory = DirectsellSubCategories::create([
                    'category_id' => $directSellCategory->id,
                    'name' => $subcategoryName,
                ]);
            }

            return redirect()->back()->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Failed to update category.');
        }
    }

    public function deletecate($id)
    {
        $category = DirectsellCategories::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
