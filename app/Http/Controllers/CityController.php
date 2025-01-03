<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\Master\City;
use App\Models\Master\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cities = City::query()->with('provinces');

            if ($request->search) {
                $cities->where('name', 'like', "%{$request->search}%");
            }
            $provinces = Province::all();
            $cities = $cities->paginate(10);
            return view('master.city.index', compact('cities', 'provinces'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $provinces = Province::all();
            return view('master.city.create', compact('provinces'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(CityRequest $request)
    {
        DB::beginTransaction();
        try {
            City::create($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'Kota berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Kota: ' . $e->getMessage());
        }
    }

    public function show(City $city)
    {
        try {
            $provinces = Province::all();
            return view('master.city.edit', compact('city', 'provinces'))->with('viewMode', true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(City $city)
    {
        try {
            $provinces = Province::all();
            return view('master.city.edit', compact('city', 'provinces'))->with('viewMode', false);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(CityRequest $request, City $city)
    {
        DB::beginTransaction();
        try {
            $city->update($request->validated());
            DB::commit();
            return redirect()
                ->route('cities.index')
                ->with('success', 'Kota berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Kota: ' . $e->getMessage());
        }
    }

    public function destroy(City $city)
    {
        DB::beginTransaction();
        try {
            $city->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Kota berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Kota: ' . $e->getMessage());
        }
    }
}
