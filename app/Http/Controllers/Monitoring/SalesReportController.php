<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\TblSalesReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $salesReports = TblSalesReport::query();

            if ($request->search) {
                $salesReports->where('report_month', 'like', "%{$request->search}%")
                    ->orWhereHas('merchant', function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search}%");
                    })
                    ->orWhereHas('product', function ($query) use ($request) {
                        $query->where('product_name', 'like', "%{$request->search}%");
                    });
            }

            $salesReports = $salesReports->with(['merchant', 'product'])->paginate(10);
            return view('sales-reports.index', compact('salesReports'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('sales-reports.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'merchant_id' => 'required|integer|exists:tbl_merchants,id',
                'product_id' => 'required|integer|exists:tbl_products,id',
                'total_sales' => 'required|numeric',
                'sales_quantity' => 'required|integer',
                'report_month' => 'required|date',
            ]);

            TblSalesReport::create($validated);

            DB::commit();
            return redirect()->route('sales-reports.index')->with('success', 'Laporan penjualan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Laporan penjualan: ' . $e->getMessage());
        }
    }

    public function show(TblSalesReport $salesReport)
    {
        try {
            return view('sales-reports.show', compact('salesReport'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(TblSalesReport $salesReport)
    {
        try {
            return view('sales-reports.edit', compact('salesReport'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TblSalesReport $salesReport)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'merchant_id' => 'required|integer|exists:tbl_merchants,id',
                'product_id' => 'required|integer|exists:tbl_products,id',
                'total_sales' => 'required|numeric',
                'sales_quantity' => 'required|integer',
                'report_month' => 'required|date',
            ]);

            $salesReport->update($validated);

            DB::commit();
            return redirect()->route('sales-reports.index')->with('success', 'Laporan penjualan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Laporan penjualan: ' . $e->getMessage());
        }
    }

    public function destroy(TblSalesReport $salesReport)
    {
        DB::beginTransaction();
        try {
            $salesReport->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Laporan penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Laporan penjualan: ' . $e->getMessage());
        }
    }
}
