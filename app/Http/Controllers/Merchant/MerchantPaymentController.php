<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\TblMerchantPayment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantPaymentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $payments = TblMerchantPayment::query();

            if ($request->search) {
                $payments->where('order_id', 'like', "%{$request->search}%")
                    ->orWhere('amount', 'like', "%{$request->search}%");
            }

            $payments = $payments->with('merchant')->paginate(10);
            return view('merchant-payments.index', compact('payments'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('merchant-payments.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'merchant_id' => 'required|integer',
                'order_id' => 'required|integer',
                'amount' => 'required|numeric',
                'payment_date' => 'required|date',
            ]);

            TblMerchantPayment::create($validated);

            DB::commit();
            return redirect()->route('merchant-payments.index')->with('success', 'Pembayaran berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Pembayaran: ' . $e->getMessage());
        }
    }

    public function show(TblMerchantPayment $merchantPayment)
    {
        try {
            return view('merchant-payments.show', compact('merchantPayment'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(TblMerchantPayment $merchantPayment)
    {
        try {
            return view('merchant-payments.edit', compact('merchantPayment'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TblMerchantPayment $merchantPayment)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'merchant_id' => 'required|integer',
                'order_id' => 'required|integer',
                'amount' => 'required|numeric',
                'payment_date' => 'required|date',
            ]);

            $merchantPayment->update($validated);

            DB::commit();
            return redirect()->route('merchant-payments.index')->with('success', 'Pembayaran berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Pembayaran: ' . $e->getMessage());
        }
    }

    public function destroy(TblMerchantPayment $merchantPayment)
    {
        DB::beginTransaction();
        try {
            $merchantPayment->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Pembayaran berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Pembayaran: ' . $e->getMessage());
        }
    }
}
