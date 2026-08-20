<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\AddNewCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return CategoryResource::collection($categories)
            ->additional([
                'message' => 'Categories successfully retrieved.',
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddNewCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return $this->successResponse(
            data: CategoryResource::make($category),
            message: 'Category successfully created.',
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return $this->successResponse(
            data: CategoryResource::make($category),
            message: 'Category successfully updated.',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->successResponse(
            message: 'Category successfully deleted.',
            status: Response::HTTP_NO_CONTENT
        );
    }
}
