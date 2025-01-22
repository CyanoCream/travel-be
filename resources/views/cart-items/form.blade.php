{{-- form.blade.php --}}
<div class="mb-3">
    <label class="form-label required">Produk</label>
    <select name="product_id" class="form-control @error('product_id') is-invalid @enderror" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
        <option value="">Pilih Produk</option>
        @foreach($products as $product)
            <option value="{{ $product->id }}" {{ (isset($cartItem) && $cartItem->product_id == $product->id) ? 'selected' : '' }}>
                {{ $product->product_name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
            </option>
        @endforeach
    </select>
    @error('product_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Jumlah</label>
    <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
           value="{{ old('quantity', $cartItem->quantity ?? 1) }}" min="1" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('quantity')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
