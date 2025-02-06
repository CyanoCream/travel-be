<div class="mb-3">
    <label class="form-label required">Order ID</label>
    <input type="number" name="order_id" class="form-control @error('order_id') is-invalid @enderror"
           value="{{ old('order_id', $payment->order_id ?? '') }}" required>
    @error('order_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Metode Pembayaran</label>
    <select name="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
        <option value="cash" {{ old('payment_method', $payment->payment_method ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="credit_card" {{ old('payment_method', $payment->payment_method ?? '') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
        <option value="debit_card" {{ old('payment_method', $payment->payment_method ?? '') == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
        <option value="transfer" {{ old('payment_method', $payment->payment_method ?? '') == 'transfer' ? 'selected' : '' }}>Transfer</option>
    </select>
    @error('payment_method')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Jumlah</label>
    <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror"
           value="{{ old('amount', $payment->amount ?? '') }}" required>
    @error('amount')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Status</label>
    <select name="payment_status" class="form-control @error('payment_status') is-invalid @enderror" required>
        <option value="1" {{ old('payment_status', $payment->payment_status ?? '') == 1 ? 'selected' : '' }}>Pending</option>
        <option value="2" {{ old('payment_status', $payment->payment_status ?? '') == 2 ? 'selected' : '' }}>Success</option>
        <option value="3" {{ old('payment_status', $payment->payment_status ?? '') == 3 ? 'selected' : '' }}>Failed</option>
    </select>
    @error('payment_status')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Tanggal Pembayaran</label>
    <input type="datetime-local" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror"
           value="{{ old('payment_date', $payment->payment_date ? $payment->payment_date->format('Y-m-d\TH:i') : '') }}" required>
    @error('payment_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
