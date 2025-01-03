<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvinceRequest;
use App\Models\Master\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {

        try {
            $provinces = Province::query();

            if ($request->search) {
                $provinces->where('name', 'like', "%{$request->search}%");
            }

            $provinces = $provinces->paginate(10);
            return view('master.provinces.index', compact('provinces'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(ProvinceRequest $request)
    {
        DB::beginTransaction();
        try {
            Province::create($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'Provinsi berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Provinsi: ' . $e->getMessage());
        }
    }

    public function show(Province $province)
    {
        try {
            return view('master.provinces.edit', compact('province'))->with('viewMode', true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Province $province)
    {
        try {
            return view('master.provinces.edit', compact('province'))->with('viewMode', false);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(ProvinceRequest $request, Province $province)
    {
        DB::beginTransaction();
        try {
            $province->update($request->validated());
            DB::commit();
            return redirect()
                ->route('provinces.index')
                ->with('success', 'Provinsi berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Provinsi: ' . $e->getMessage());
        }
    }

    public function destroy(Province $province)
    {
        DB::beginTransaction();
        try {
            $province->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Provinsi berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Provinsi: ' . $e->getMessage());
        }
    }
}
