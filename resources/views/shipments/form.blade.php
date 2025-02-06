<div class="mb-3">
    <label class="form-label required">Order ID</label>
    <input type="number" name="order_id" class="form-control @error('order_id') is-invalid @enderror"
           value="{{ old('order_id', $shipment->order_id ?? '') }}" required>
    @error('order_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Alamat Pengiriman</label>
    <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" required>{{ old('shipping_address', $shipment->shipping_address ?? '') }}</textarea>
    @error('shipping_address')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Status Pengiriman</label>
    <select name="shipping_status" class="form-control @error('shipping_status') is-invalid @enderror" required>
        <option value="pending" {{ old('shipping_status', $shipment->shipping_status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="shipped" {{ old('shipping_status', $shipment->shipping_status ?? '') == 'shipped' ? 'selected' : '' }}>Shipped</option>
        <option value="delivered" {{ old('shipping_status', $shipment->shipping_status ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
    </select>
    @error('shipping_status')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Nomor Resi</label>
    <input type="text" name="tracking_number" class="form-control @error('tracking_number') is-invalid @enderror"
           value="{{ old('tracking_number', $shipment->tracking_number ?? '') }}" required>
    @error('tracking_number')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Tanggal Pengiriman</label>
    <input type="datetime-local" name="shipped_at" class="form-control @error('shipped_at') is-invalid @enderror"
           value="{{ old('shipped_at', $shipment->shipped_at ? $shipment->shipped_at->format('Y-m-d\TH:i') : '') }}" required>
    @error('shipped_at')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
