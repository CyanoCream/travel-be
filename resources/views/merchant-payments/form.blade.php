<div class="mb-3">
    <label class="form-label required">Merchant ID</label>
    <input type="number" name="merchant_id" class="form-control @error('merchant_id') is-invalid @enderror"
           value="{{ old('merchant_id', $merchantPayment->merchant_id ?? '') }}" required>
    @error('merchant_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Order ID</label>
    <input type="number" name="order_id" class="form-control @error('order_id') is-invalid @enderror"
           value="{{ old('order_id', $merchantPayment->order_id ?? '') }}" required>
    @error('order_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Amount</label>
    <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror"
           value="{{ old('amount', $merchantPayment->amount ?? '') }}" required>
    @error('amount')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Payment Date</label>
    <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror"
           value="{{ old('payment_date', $merchantPayment->payment_date ?? '') }}" required>
    @error('payment_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
