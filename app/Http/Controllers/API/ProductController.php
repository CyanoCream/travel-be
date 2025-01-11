<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TblProduct;
use App\Models\TblProductCategory;
use App\Models\TblProductPicture;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProduct(Request $request)
    {
        try {

            // Query products with optional search
            $category = TblProductCategory::all();
            $products = TblProduct::query();
            if ($request->search) {
                $products->where('product_name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            }

            // Fetch products with category and pictures
            $products = $products->with(['category', 'pictures' => function ($query) {
                $query->limit(1);
            }])->paginate(10);

            // Transform products according to new format
            $transformedProducts = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'slug' => $product->slug,
                    'price' => (float) $product->price,
                    'status' => $product->status,
                    'image' => $product->pictures->first() ? $product->pictures->first()->picture : null,
                    'category' => $product->category ? $product->category->name : null,
                    'createdAt' => $product->created_at->toISOString()
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Products retrieved successfully',
                'products' => $transformedProducts,
                'categories' => $category,
                'totalPages' => $products->lastPage(),
                'currentPage' => $products->currentPage(),
                'totalProducts' => $products->total()
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getProductBySlug(Request $request, $slug)
    {
        try {
            // Fetch product with category and all pictures
            $product = TblProduct::with(['category', 'pictures', 'merchant'])
                ->where('slug', $slug)
                ->first();

            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Transform product data
            $transformedProduct = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => (float) $product->price,
                'status' => $product->status,
                'description' => $product->description,
                'merchant' => $product->merchant ? [
                    'id' => $product->merchant->id,
                    'name' => $product->merchant->name
                ] : null,
                'category' => $product->category ? [
                    'id' => $product->category->id,
                    'name' => $product->category->name
                ] : null,
                'images' => $product->pictures->map(function($picture) {
                    return [
                        'id' => $picture->id,
                        'url' => $picture->picture
                    ];
                }),
                'stock' => $product->stock,
                'createdAt' => $product->created_at->toISOString()
            ];

            return response()->json([
                'status' => true,
                'message' => 'Product detail retrieved successfully',
                'product' => $transformedProduct
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
