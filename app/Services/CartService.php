<?php

namespace App\Services;

use App\Models\TblCartItem;
use App\Models\TblProduct;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function getCart()
    {
        return TblCartItem::with(['product.pictures'])
            ->get()
            ->map(function ($item) {
                $gambar = StorageService::getData( $item->product->pictures->first()->picture?? '');
                return [
                    'id' => $item->id,
                    'name' => $item->product->product_name,
                    'price' => (float) $item->price,
                    'quantity' => $item->quantity,
                    'total_price' => (float) $item->total_price,
                    'image' => $gambar,
                    'product_id' => $item->product_id
                ];
            });
    }

    public function addToCart($productId, $quantity)
    {
        $product = TblProduct::findOrFail($productId);

        if ($product->stock < $quantity) {
            throw new \Exception('Stock tidak mencukupi');
        }

        $existingItem = TblCartItem::where('product_id', $productId)->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                throw new \Exception('Stock tidak mencukupi');
            }

            $existingItem->quantity = $newQuantity;
            $existingItem->total_price = $product->price * $newQuantity;
            $existingItem->save();

            return $existingItem;
        }

        return TblCartItem::create([
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $product->price,
            'total_price' => $product->price * $quantity
        ]);
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $cartItem = TblCartItem::with('product')->findOrFail($cartItemId);

        if ($cartItem->product->stock < $quantity) {
            throw new \Exception('Stock tidak mencukupi');
        }

        $cartItem->quantity = $quantity;
        $cartItem->total_price = $cartItem->price * $quantity;
        $cartItem->save();

        return $cartItem;
    }

    public function removeItem($cartItemId)
    {
        return TblCartItem::findOrFail($cartItemId)->delete();
    }

    public function clearCart()
    {
        return TblCartItem::truncate();
    }

    public function getCartSummary()
    {
        $items = TblCartItem::all();

        return [
            'subtotal' => $items->sum('total_price'),
            'total_items' => $items->sum('quantity'),
            'total' => $items->sum('total_price') // This could include tax, shipping, etc.
        ];
    }
}
