<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\TblPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $payments = TblPayment::query();

            if ($request->search) {
                $payments->where('payment_method', 'like', "%{$request->search}%")
                    ->orWhere('amount', 'like', "%{$request->search}%");
            }

            $payments = $payments->with('order')->paginate(10);
            return view('payments.index', compact('payments'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:tbl_orders,id',
                'payment_method' => 'required|in:cash,credit_card,debit_card,transfer',
                'amount' => 'required|numeric',
                'payment_status' => 'required|in:1,2,3', // 1: Pending, 2: Success, 3: Failed
                'payment_date' => 'required|date',
            ]);

            TblPayment::create($validated);

            DB::commit();
            return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Pembayaran: ' . $e->getMessage());
        }
    }

    public function show(TblPayment $payment)
    {
        try {
            return view('payments.show', compact('payment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(TblPayment $payment)
    {
        try {
            return view('payments.edit', compact('payment'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, TblPayment $payment)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:tbl_orders,id',
                'payment_method' => 'required|in:cash,credit_card,debit_card,transfer',
                'amount' => 'required|numeric',
                'payment_status' => 'required|in:1,2,3', // 1: Pending, 2: Success, 3: Failed
                'payment_date' => 'required|date',
            ]);

            $payment->update($validated);

            DB::commit();
            return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Pembayaran: ' . $e->getMessage());
        }
    }

    public function destroy(TblPayment $payment)
    {
        DB::beginTransaction();
        try {
            $payment->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Pembayaran: ' . $e->getMessage());
        }
    }
}
