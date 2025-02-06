<div class="mb-3">
    <label class="form-label required">Merchant</label>
    <select name="merchant_id" class="form-control @error('merchant_id') is-invalid @enderror" required>
        <option value="">Pilih Merchant</option>
        @foreach($merchants as $merchant)
            <option value="{{ $merchant->id }}" {{ old('merchant_id', $salesReport->merchant_id ?? '') == $merchant->id ? 'selected' : '' }}>
                {{ $merchant->name }}
            </option>
        @endforeach
    </select>
    @error('merchant_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Produk</label>
    <select name="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
        <option value="">Pilih Produk</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}" {{ old('product_id', $salesReport->product_id ?? '') == $product->id ? 'selected' : '' }}>
                {{ $product->product_name }}
            </option>
        @endforeach
    </select>
    @error('product_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Total Penjualan</label>
    <input type="number" step="0.01" name="total_sales" class="form-control @error('total_sales') is-invalid @enderror"
           value="{{ old('total_sales', $salesReport->total_sales ?? '') }}" required>
    @error('total_sales')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Jumlah Penjualan</label>
    <input type="number" name="sales_quantity" class="form-control @error('sales_quantity') is-invalid @enderror"
           value="{{ old('sales_quantity', $salesReport->sales_quantity ?? '') }}" required>
    @error('sales_quantity')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Bulan Laporan</label>
    <input type="month" name="report_month" class="form-control @error('report_month') is-invalid @enderror"
           value="{{ old('report_month', $salesReport->report_month ? $salesReport->report_month->format('Y-m') : '') }}" required>
    @error('report_month')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
