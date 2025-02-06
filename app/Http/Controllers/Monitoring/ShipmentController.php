<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\TblShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $shipments = TblShipment::query();

            if ($request->search) {
                $shipments->where('tracking_number', 'like', "%{$request->search}%")
                    ->orWhere('shipping_address', 'like', "%{$request->search}%");
            }

            $shipments = $shipments->with('order')->paginate(10);
            return view('shipments.index', compact('shipments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('shipments.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:tbl_orders,id',
                'shipping_address' => 'required|string',
                'shipping_status' => 'required|in:pending,shipped,delivered',
                'tracking_number' => 'required|string|unique:tbl_shipments,tracking_number',
                'shipped_at' => 'required|date',
            ]);

            TblShipment::create($validated);

            DB::commit();
            return redirect()->route('shipments.index')->with('success', 'Pengiriman berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Pengiriman: ' . $e->getMessage());
        }
    }

    public function show(TblShipment $shipment)
    {
        try {
            return view('shipments.show', compact('shipment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(TblShipment $shipment)
    {
        try {
            return view('shipments.edit', compact('shipment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TblShipment $shipment)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:tbl_orders,id',
                'shipping_address' => 'required|string',
                'shipping_status' => 'required|in:pending,shipped,delivered',
                'tracking_number' => 'required|string|unique:tbl_shipments,tracking_number,' . $shipment->id,
                'shipped_at' => 'required|date',
            ]);

            $shipment->update($validated);

            DB::commit();
            return redirect()->route('shipments.index')->with('success', 'Pengiriman berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Pengiriman: ' . $e->getMessage());
        }
    }

    public function destroy(TblShipment $shipment)
    {
        DB::beginTransaction();
        try {
            $shipment->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Pengiriman berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Pengiriman: ' . $e->getMessage());
        }
    }
}
