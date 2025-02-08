<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\Schema;

use App\Models\Subcategory;
use Illuminate\Support\Facades\Validator;


class CategoryControllerAdmin extends Controller
{

    //Category Function Start Here
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'title' => 'required|string',
                'slug' => 'required|string|unique:news_categories,slug',
                'meta_title' => 'required|string',
                'description' => 'required|string',
                'meta_description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'color' => 'nullable|string',
                'sort_order' => 'nullable|integer',
                'parent_id' => 'nullable|integer',
                'is_featured' => 'nullable|boolean',
                'is_active' => 'nullable|boolean',
                'seo_keywords' => 'nullable|string',
                'visibility' => 'nullable|string',
                'author' => 'nullable|string',
                'language' => 'nullable|string',
                'allow_comments' => 'nullable|boolean',
                'additional_data' => 'nullable|json',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
            $validated = $validator->validated();
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('news_categories/images', 'public');
            }
            $iconPath = null;
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('news_categories/icons', 'public');
            }
            $data = [
                'name' => $validated['name'],
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'meta_title' => $validated['meta_title'],
                'description' => $validated['description'],
                'meta_description' => $validated['meta_description'],
                'image' => $imagePath,
                'icon' => $iconPath,
                'color' => isset($validated['color']) ? $validated['color'] : null,
                'sort_order' => isset($validated['sort_order']) ? $validated['sort_order'] : null,
                'parent_id' => isset($validated['parent_id']) ? $validated['parent_id'] : null,
                'is_featured' => isset($validated['is_featured']) ? $validated['is_featured'] : false,
                'is_active' => isset($validated['is_active']) ? $validated['is_active'] : false,
                'seo_keywords' => isset($validated['seo_keywords']) ? $validated['seo_keywords'] : null,
                'visibility' => isset($validated['visibility']) ? $validated['visibility'] : null,
                'author' => isset($validated['author']) ? $validated['author'] : null,
                'language' => isset($validated['language']) ? $validated['language'] : null,
                'allow_comments' => isset($validated['allow_comments']) ? $validated['allow_comments'] : false,
                'additional_data' => isset($validated['additional_data']) ? $validated['additional_data'] : null,
            ];
            $category = NewsCategory::create($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function getCategories(Request $request){
        try {
            $getCategories = NewsCategory::where('is_active', 0)->orderBy('id','desc')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Categories Fetch Successfully',
                'data' => $getCategories
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function GetCategoriesDetails(Request $request){
        try {
            $category_id  = $request->category_id;
            $getCategories = NewsCategory::where('id',$category_id)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Category Details Fetch Successfully',
                'data' => $getCategories
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function UpdateCategories(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'categories_id' => 'required|integer|exists:news_categories,id',
            'name' => 'nullable|string',
            'title' => 'nullable|string',
            'slug' => 'nullable|string|unique:news_categories,slug,' . $request->categories_id,
            'meta_title' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'seo_keywords' => 'nullable|string',
            'visibility' => 'nullable|string',
            'author' => 'nullable|string',
            'language' => 'nullable|string',
            'allow_comments' => 'nullable|boolean',
            'additional_data' => 'nullable|json',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $category = NewsCategory::find($request->categories_id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found.'
            ], 404);
        }
        $data = [];
        if (isset($request->name)) $data['name'] = $request->name;
        if (isset($request->title)) $data['title'] = $request->title;
        if (isset($request->slug)) $data['slug'] = $request->slug;
        if (isset($request->meta_title)) $data['meta_title'] = $request->meta_title;
        if (isset($request->description)) $data['description'] = $request->description;
        if (isset($request->meta_description)) $data['meta_description'] = $request->meta_description;
        if (isset($request->color)) $data['color'] = $request->color;
        if (isset($request->sort_order)) $data['sort_order'] = $request->sort_order;
        if (isset($request->parent_id)) $data['parent_id'] = $request->parent_id;
        if (isset($request->is_featured)) $data['is_featured'] = $request->is_featured;
        if (isset($request->is_active)) $data['is_active'] = $request->is_active;
        if (isset($request->seo_keywords)) $data['seo_keywords'] = $request->seo_keywords;
        if (isset($request->visibility)) $data['visibility'] = $request->visibility;
        if (isset($request->author)) $data['author'] = $request->author;
        if (isset($request->language)) $data['language'] = $request->language;
        if (isset($request->allow_comments)) $data['allow_comments'] = $request->allow_comments;
        if (isset($request->additional_data)) $data['additional_data'] = $request->additional_data;
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('news_categories/images', 'public');
            $data['image'] = $imagePath;
        } else {
            $data['image'] = $category->image;
        }

        if ($request->hasFile('icon')) {
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $iconPath = $request->file('icon')->store('news_categories/icons', 'public');
            $data['icon'] = $iconPath;
        } else {
            $data['icon'] = $category->icon;
        }

        $category->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully.',
            'data' => $category
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.',
            'error' => $th->getMessage()
        ], 500);
    }
}


public function DeleteCategories(Request $request)
{
    try {
        $category_id = $request->category_id;
        $findCategory = NewsCategory::find($category_id);

        if (!$findCategory) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found.'
            ], 404); 
        }
        $deletedCategory = $findCategory;
        $findCategory->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category Deleted Successfully',
            'data' => $deletedCategory
        ], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.',
            'error' => $th->getMessage()
        ], 500);
    }
}

//Category Function End Here



// Subcategory Controller Function Start Here

public function  SubCategoryCreate(Request $request){
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category_id' => 'required|integer|exists:news_categories,id',
            'title' => 'required|string',
            'slug' => 'required|string|unique:news_categories,slug',
            'meta_title' => 'required|string',
            'description' => 'required|string',
            'meta_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'seo_keywords' => 'nullable|string',
            'visibility' => 'nullable|string',
            'author' => 'nullable|string',
            'language' => 'nullable|string',
            'allow_comments' => 'nullable|boolean',
            'additional_data' => 'nullable|json',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $validated = $validator->validated();
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_subcategories/images', 'public');
        }
        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('news_subcategories/icons', 'public');
        }
        $data = [
            'name' => $validated['name'],
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'meta_title' => $validated['meta_title'],
            'description' => $validated['description'],
            'meta_description' => $validated['meta_description'],
            'image' => $imagePath,
            'icon' => $iconPath,
            'color' => isset($validated['color']) ? $validated['color'] : null,
            'sort_order' => isset($validated['sort_order']) ? $validated['sort_order'] : null,
            'parent_id' => isset($validated['parent_id']) ? $validated['parent_id'] : null,
            'is_featured' => isset($validated['is_featured']) ? $validated['is_featured'] : false,
            'is_active' => isset($validated['is_active']) ? $validated['is_active'] : false,
            'seo_keywords' => isset($validated['seo_keywords']) ? $validated['seo_keywords'] : null,
            'visibility' => isset($validated['visibility']) ? $validated['visibility'] : null,
            'author' => isset($validated['author']) ? $validated['author'] : null,
            'language' => isset($validated['language']) ? $validated['language'] : null,
            'allow_comments' => isset($validated['allow_comments']) ? $validated['allow_comments'] : false,
            'additional_data' => isset($validated['additional_data']) ? $validated['additional_data'] : null,
        ];
        $category = Subcategory::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => $category
        ], 200);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.'
        ], 500);
    }
}

public function GetSubcategories(Request $request){
    try {
        $getCategories = Subcategory::where('is_active', 0)->orderBy('id','desc')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'SubCategeory Fetch Successfully',
                'data' => $getCategories
            ],200);
    } catch (\Throwable $th) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.'
        ], 500);
    }
}

public function GetSubCategoriesDetails(Request $request){
    try {
        $subcategory_id  = $request->sub_catgeory_id;
        $getCategories = Subcategory::where('id',$subcategory_id)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Sub Category Details Fetch Successfully',
            'data' => $getCategories
        ]);

    } catch (\Throwable $th) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.'
        ], 500);
    }
}

public function UpdateSubcategories(Request $request){
    try {
        $validator = Validator::make($request->all(), [
            'subcategories_id' => 'required|integer|exists:subcategories,id',
            'category_id' => 'required|integer|exists:news_categories,id',
            'name' => 'nullable|string',
            'title' => 'nullable|string',
            'slug' => 'nullable|string|unique:news_categories,slug,' . $request->subcategories_id,
            'meta_title' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'color' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'seo_keywords' => 'nullable|string',
            'visibility' => 'nullable|string',
            'author' => 'nullable|string',
            'language' => 'nullable|string',
            'allow_comments' => 'nullable|boolean',
            'additional_data' => 'nullable|json',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $category = Subcategory::find($request->subcategories_id);
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found.'
            ], 404);
        }
        $data = [];
        if (isset($request->name)) $data['name'] = $request->name;
        if (isset($request->category_id)) $data['category_id'] = $request->name;
        if (isset($request->title)) $data['title'] = $request->title;
        if (isset($request->slug)) $data['slug'] = $request->slug;
        if (isset($request->meta_title)) $data['meta_title'] = $request->meta_title;
        if (isset($request->description)) $data['description'] = $request->description;
        if (isset($request->meta_description)) $data['meta_description'] = $request->meta_description;
        if (isset($request->color)) $data['color'] = $request->color;
        if (isset($request->sort_order)) $data['sort_order'] = $request->sort_order;
        if (isset($request->parent_id)) $data['parent_id'] = $request->parent_id;
        if (isset($request->is_featured)) $data['is_featured'] = $request->is_featured;
        if (isset($request->is_active)) $data['is_active'] = $request->is_active;
        if (isset($request->seo_keywords)) $data['seo_keywords'] = $request->seo_keywords;
        if (isset($request->visibility)) $data['visibility'] = $request->visibility;
        if (isset($request->author)) $data['author'] = $request->author;
        if (isset($request->language)) $data['language'] = $request->language;
        if (isset($request->allow_comments)) $data['allow_comments'] = $request->allow_comments;
        if (isset($request->additional_data)) $data['additional_data'] = $request->additional_data;
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('news_subcategories/images', 'public');
            $data['image'] = $imagePath;
        } else {
            $data['image'] = $category->image;
        }

        if ($request->hasFile('icon')) {
            if ($category->icon) {
                Storage::disk('public')->delete($category->icon);
            }
            $iconPath = $request->file('icon')->store('news_subcategories/icons', 'public');
            $data['icon'] = $iconPath;
        } else {
            $data['icon'] = $category->icon;
        }

        $category->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully.',
            'data' => $category
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.',
            'error' => $th->getMessage()
        ], 500);
    }
}

public function DeleteSubcategories(Request $request){
    try {
        $subcategory_id = $request->subcategory_id;
        $findCategory = Subcategory::find($subcategory_id);

        if (!$findCategory) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sub Category not found.'
            ], 404); 
        }
        $deletedCategory = $findCategory;
        $findCategory->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Sub Category Deleted Successfully',
            'data' => $deletedCategory
        ], 200);
    } catch (\Throwable $th) {
        //throw $th;
    }
}

// Subcategory Controller Function End Here


//mapping columns


public function getColumns()
    {
        // Fetch all column names from the categories table
        $columns = Schema::getColumnListing('news_categories');
        
        return response()->json(['columns' => $columns]);
    }



}
