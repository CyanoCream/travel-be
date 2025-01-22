<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\TblCartItem;
use App\Models\TblProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    public function index()
    {
        try {
            $cartItems = TblCartItem::with('product')->paginate(10);
            return view('cart-items.index', compact('cartItems'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $products = TblProduct::where('status', true)->get();
            return view('cart-items.create', compact('products'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:tbl_products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Get product price
            $product = TblProduct::findOrFail($validated['product_id']);
            $validated['price'] = $product->price;
            $validated['total_price'] = $validated['price'] * $validated['quantity'];

            TblCartItem::create($validated);

            DB::commit();
            return redirect()->route('cart-items.index')->with('success', 'Item berhasil ditambahkan ke keranjang');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan item: ' . $e->getMessage());
        }
    }

    public function show(TblCartItem $cartItem)
    {
        try {
            return view('cart-items.show', compact('cartItem'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(TblCartItem $cartItem)
    {
        try {
            $products = TblProduct::where('status', true)->get();
            return view('cart-items.edit', compact('cartItem', 'products'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TblCartItem $cartItem)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:tbl_products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Update price if product changed
            if ($cartItem->product_id != $validated['product_id']) {
                $product = TblProduct::findOrFail($validated['product_id']);
                $validated['price'] = $product->price;
            }

            $validated['total_price'] = $validated['price'] * $validated['quantity'];

            $cartItem->update($validated);

            DB::commit();
            return redirect()->route('cart-items.index')->with('success', 'Item keranjang berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui item: ' . $e->getMessage());
        }
    }

    public function destroy(TblCartItem $cartItem)
    {
        DB::beginTransaction();
        try {
            $cartItem->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus item: ' . $e->getMessage());
        }
    }

    public function getCartTotal()
    {
        try {
            $total = TblCartItem::sum('total_price');
            return response()->json(['total' => $total]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
