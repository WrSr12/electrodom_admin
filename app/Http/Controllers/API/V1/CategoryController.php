<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\Product\OrderByEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\IndexCategoryResource;
use App\Models\Category;
use App\Services\API\V1\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index()
    {
        return IndexCategoryResource::collection($this->categoryService->getWithSubcategories());
    }

    public function show(Category $category)
    {
        return CategoryResource::make($category);
    }

    public function getFilters(Category $category): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'attributes' => $category->attributesWithUnitTitleAndValues(),
            'prices' => $category->getMinAndMaxPrices(),
            'orderBy' => OrderByEnum::cases(),
        ]);
    }
}
