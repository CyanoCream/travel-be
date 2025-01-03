<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\TblProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $categories = TblProductCategory::query();
//            dd($categories);
            if ($request->search) {
                $categories->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            }

            $categories = $categories->paginate(10);
            return view('product-categories.index', compact('categories'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string'
            ]);

            TblProductCategory::create($validated);

            return redirect()->back()->with('success', 'Kategori Produk berhasil ditambahkan');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan Kategori Produk: ' . $e->getMessage());
        }
    }

    public function show(TblProductCategory $productCategory)
    {
        return view('product-categories.edit', compact('productCategory'))->with('viewMode', true);
    }

    public function edit(TblProductCategory $productCategory)
    {
        return view('product-categories.edit', compact('productCategory'))->with('viewMode', false);
    }

    public function update(Request $request, TblProductCategory $productCategory)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|integer'
            ]);

            $productCategory->update($validated);

            return redirect()->route('product-category.index')->with('success', 'Kategori Produk berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui Kategori Produk: ' . $e->getMessage());
        }
    }

    public function destroy(TblProductCategory $productCategory)
    {
        try {
            $productCategory->delete();
            return redirect()->back()->with('success', 'Kategori Produk berhasil dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Kategori Produk: ' . $e->getMessage());
        }
    }
}
