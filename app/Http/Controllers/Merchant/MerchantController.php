<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Master\City;
use App\Models\TblMerchant;
use App\Services\StorageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function index()
    {
        try {
            $merchants = TblMerchant::paginate(10);
            $cities = City::all();
            // Process pictures for each merchant
            foreach($merchants as $merchant) {
                if($merchant->display_picture) {
                    $merchant->display_picture_url = StorageService::getData($merchant->display_picture);
                }
            }

            return view('merchants.index', compact('merchants', 'cities'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('merchants.create');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'city_id' => 'required|integer',
                'address' => 'required|string',
                'contact_person' => 'required|string',
                'status' => 'required|boolean',
                'display_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('display_picture')) {
                $uploadResult = StorageService::upload(
                    $request->file('display_picture'),
                    'merchants',
                    time() . '-' . $request->file('display_picture')->getClientOriginalName()
                );
                $validated['display_picture'] = $uploadResult['file_path'] . '/' . $uploadResult['file_name'];
            }

            TblMerchant::create($validated);

            DB::commit();
            return redirect()->route('merchants.index')->with('success', 'Merchant berhasil ditambahkan');
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Merchant: ' . $e->getMessage());
        }
    }

    public function show(TblMerchant $merchant)
    {
        try {
            $picture = null;
            if ($merchant->display_picture) {
                $picture = StorageService::getData($merchant->display_picture);
            }
            return view('merchants.show', compact('merchant', 'picture'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(TblMerchant $merchant)
    {
        try {
            $picture = null;
            if ($merchant->display_picture) {
                $picture = StorageService::getData($merchant->display_picture);
            }
            $cities = City::all();
            return view('merchants.edit', compact('merchant', 'picture', 'cities'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TblMerchant $merchant)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'name' => 'required|integer',
                'city_id' => 'required|integer',
                'address' => 'required|string',
                'contact_person' => 'required|string',
                'status' => 'required|boolean',
                'display_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('display_picture')) {
                // Delete old picture if exists
                if ($merchant->display_picture) {
                    StorageService::delete($merchant->display_picture);
                }

                $uploadResult = StorageService::upload(
                    $request->file('display_picture'),
                    'merchants',
                    time() . '-' . $request->file('display_picture')->getClientOriginalName()
                );
                $validated['display_picture'] = $uploadResult['file_path'] . '/' . $uploadResult['file_name'];
            }

            $merchant->update($validated);

            DB::commit();
            return redirect()->route('merchant.index')->with('success', 'Merchant berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Merchant: ' . $e->getMessage());
        }
    }

    public function destroy(TblMerchant $merchant)
    {
        DB::beginTransaction();
        try {
            if ($merchant->display_picture) {
                StorageService::delete($merchant->display_picture);
            }

            $merchant->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Merchant berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Merchant: ' . $e->getMessage());
        }
    }
}
