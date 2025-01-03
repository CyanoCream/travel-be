<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TblProduct;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProduct(Request $request)
    {
        try {
            // Query products with optional search
            $products = TblProduct::query();

            if ($request->search) {
                $products->where('product_name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            }

            // Fetch products with category and first picture
            $products = $products->with(['category', 'pictures' => function ($query) {
                $query->limit(1);
            }])->paginate(10);

            // Transform products for API response
            $response = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'description' => $product->description,
                    'category' => $product->category ? $product->category->name : null,
                    'picture' => $product->pictures->isNotEmpty() ? $product->pictures[0]->picture : null,
                ];
            });

            return response()->json([
                'data' => $response,
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    public function getProductBySlug(Request $request, $slug)
    {
        try {
            // Find product by slug with its relationships
            $product = TblProduct::with(['category'])
                ->where('slug', $slug)
                ->firstOrFail();

            // Transform product for API response
            $response = [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'category' => $product->category ? $product->category->name : null,
                'slug' => $product->slug
            ];

            return response()->json([
                'data' => $response
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
