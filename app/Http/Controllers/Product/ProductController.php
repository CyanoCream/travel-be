<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\TblProduct;
use App\Models\TblProductCategory;
use App\Models\TblProductPicture;
use App\Services\StorageService;
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
                'pictures.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Add validation for images
            ]);

            $product = TblProduct::create($validated);

            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $picture) {
                    // Use StorageService to upload the file
                    $uploadResult = StorageService::upload(
                        $picture,
                        'products/' . $product->id, // Create subfolder for each product
                        time() . '-' . $picture->getClientOriginalName()
                    );

                    // Save the picture information to database
                    TblProductPicture::create([
                        'product_id' => $product->id,
                        'picture' => $uploadResult['file_path'] . '/' . $uploadResult['file_name']
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
            return view('products.edit', compact('product', 'categories', 'pictures', 'viewMode'))
                ->with('storageService', app(StorageService::class));
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

    public function showImage(){
        return StorageService::getData($this->photo);
    }
}
