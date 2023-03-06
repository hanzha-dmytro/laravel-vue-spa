<?php

namespace App\Http\Controllers;

use App\Http\Filters\CategoryFilter;
use App\Http\Requests\CategoryIndexRequest;
use App\Http\Requests\CategorySaveRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(CategoryIndexRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CategoryResource::collection(
            Category::filter(new CategoryFilter($request))->paginate(Category::PAGINATION_LIMIT)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategorySaveRequest $request
     * @return CategoryResource
     */
    public function store(CategorySaveRequest $request): CategoryResource
    {
        $category = new Category($request->only('name', 'slug', 'description', 'is_visible'));

        if($request->hasFile('image')) {
            $category->image = $request->image->store('images/category', 'public');
        }

        $category->save();
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategorySaveRequest $request
     * @param Category $category
     * @return CategoryResource
     */
    public function update(CategorySaveRequest $request, Category $category): CategoryResource
    {
        $category->fill($request->only('name', 'slug', 'description', 'is_visible'));

        if($request->hasFile('image')) {
            $category->image = $request->image->store('images/category', 'public');
        }

        $category->save();
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return bool|null
     */
    public function destroy(Category $category): ?bool
    {
        return $category->delete();
    }

    /**
     * Display all items of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }
}
