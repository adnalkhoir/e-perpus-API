<?php

namespace App\Http\Controllers\Api;
use App\Models\categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Contracts\Cache\Store;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = categories::latest()->paginate(5);
        return \response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = categories::create([
        'name' => $request->name
    ]);

    return response()->json([
        'message' => 'Category created successfully.',
        'data' => $category
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = categories::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found.'], 404);
    }

    $category->update([
        'name' => $request->name
    ]);

    return response()->json([
        'message' => 'Category updated successfully.',
        'data' => $category
    ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }

}




