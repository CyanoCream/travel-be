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
}
