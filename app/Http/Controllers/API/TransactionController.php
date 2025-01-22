<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getCart()
    {
        try {
            $items = $this->cartService->getCart();
            $summary = $this->cartService->getCartSummary();

            return response()->json([
                'status' => true,
                'message' => 'Cart retrieved successfully',
                'data' => [
                    'items' => $items,
                    'summary' => $summary
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addToCart(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:tbl_products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            DB::beginTransaction();

            $cartItem = $this->cartService->addToCart(
                $validated['product_id'],
                $validated['quantity']
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Item added to cart successfully',
                'data' => $cartItem
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error adding item to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateCartItem(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1'
            ]);

            DB::beginTransaction();

            $cartItem = $this->cartService->updateQuantity($id, $validated['quantity']);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cart item updated successfully',
                'data' => $cartItem
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error updating cart item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function removeCartItem($id)
    {
        try {
            DB::beginTransaction();

            $this->cartService->removeItem($id);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cart item removed successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error removing cart item: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clearCart()
    {
        try {
            DB::beginTransaction();

            $this->cartService->clearCart();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cart cleared successfully'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Error clearing cart: ' . $e->getMessage()
            ], 500);
        }
    }
}
