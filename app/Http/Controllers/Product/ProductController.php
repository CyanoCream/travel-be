<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\TblProduct;
use App\Models\TblProductCategory;
use App\Models\TblProductPicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        try {
            $products = TblProduct::query();

            if ($request->search) {
                $products->where('product_name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            }
            $categories = TblProductCategory::all();
            $products = $products->with('category')->paginate(10);
            return view('products.index', compact('products', 'categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'product_name' => 'required',
                'merchan_id' => 'required|integer',
                'type' => 'required',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'description' => 'required|string',
                'status' => 'required|boolean',
                'category_id' => 'required',

            ]);

            $product = TblProduct::create($validated);

            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $picture) {
                    $path = $picture->store('products', 'public');
                    TblProductPicture::create([
                        'product_id' => $product->id,
                        'picture' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Produk: ' . $e->getMessage());
        }
    }

    public function show(TblProduct $product)
    {
        try {
            $categories = TblProductCategory::all();
            $pictures = TblProductPicture::where('product_id', $product->id)->get();
            return view('products.edit', compact('product', 'categories', 'pictures'))->with('viewMode', true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(TblProduct $product)
    {
        try {
            $categories = TblProductCategory::all();
            $pictures = TblProductPicture::where('product_id', $product->id)->get();
            return view('products.edit', compact('product', 'categories', 'pictures'))->with('viewMode', false);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TblProduct $product)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'product_name' => 'required|integer',
                'merchan_id' => 'required|integer',
                'type' => 'required|integer',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'category_id' => 'required|exists:tbl_product_categories,id',
                'description' => 'required|string',
                'status' => 'required|boolean',
                'pictures.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $product->update($validated);

            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $picture) {
                    $path = $picture->store('products', 'public');
                    TblProductPicture::create([
                        'product_id' => $product->id,
                        'picture' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Produk: ' . $e->getMessage());
        }
    }

    public function destroy(TblProduct $product)
    {
        DB::beginTransaction();
        try {
            $pictures = TblProductPicture::where('product_id', $product->id)->get();
            foreach ($pictures as $picture) {
                Storage::disk('public')->delete($picture->picture);
                $picture->delete();
            }

            $product->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Produk: ' . $e->getMessage());
        }
    }

    public function deletePicture($id)
    {
        try {
            $picture = TblProductPicture::findOrFail($id);
            Storage::disk('public')->delete($picture->picture);
            $picture->delete();
            return response()->json(['success' => 'Gambar berhasil dihapus']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal menghapus gambar: ' . $e->getMessage()], 500);
        }
    }
}
