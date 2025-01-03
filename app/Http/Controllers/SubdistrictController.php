<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubdistrictRequest;
use App\Models\Master\City;
use App\Models\Master\Subdistrict;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubdistrictController extends Controller
{
    public function index(Request $request)
    {
        try {
            $subdistricts = Subdistrict::query()->with('city');

            if ($request->search) {
                $subdistricts->where('name', 'like', "%{$request->search}%");
            }
            $cities = City::all();
            $subdistricts = $subdistricts->paginate(10);
            return view('master.subdistricts.index', compact('subdistricts','cities'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $cities = City::all();
            return view('master.subdistricts.create', compact('cities'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(SubdistrictRequest $request)
    {
        DB::beginTransaction();
        try {
            Subdistrict::create($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'Kecamatan berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Kecamatan: ' . $e->getMessage());
        }
    }

    public function show(Subdistrict $subdistrict)
    {
        try {
            $cities = City::all();
            return view('master.subdistricts.edit', compact('subdistrict', 'cities'))->with('viewMode', true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Subdistrict $subdistrict)
    {
        try {
            $cities = City::all();
            return view('master.subdistricts.edit', compact('subdistrict', 'cities'))->with('viewMode', false);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(SubdistrictRequest $request, Subdistrict $subdistrict)
    {
        DB::beginTransaction();
        try {
            $subdistrict->update($request->validated());
            DB::commit();
            return redirect()
                ->route('subdistricts.index')
                ->with('success', 'Kecamatan berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Kecamatan: ' . $e->getMessage());
        }
    }

    public function destroy(Subdistrict $subdistrict)
    {
        DB::beginTransaction();
        try {
            $subdistrict->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Kecamatan berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Kecamatan: ' . $e->getMessage());
        }
    }
}
