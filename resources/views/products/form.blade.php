
<div class="mb-3">
    <label class="form-label required">Nama Produk</label>
    <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
           value="{{ old('product_name', $product->product_name ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('product_name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Kategori</label>
    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
        <option value="">Pilih Kategori</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (isset($product) && $product->category_id == $category->id) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">ID Merchant</label>
    <input type="number" name="merchant_id" class="form-control @error('merchant_id') is-invalid @enderror"
           value="{{ old('merchant_id', $product->merchant_id ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('merchant_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Tipe</label>
    <input type="text" name="type" class="form-control @error('type') is-invalid @enderror"
           value="{{ old('type', $product->type ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('type')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Harga</label>
    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
           value="{{ old('price', $product->price ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('price')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Stok</label>
    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
           value="{{ old('stock', $product->stock ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('stock')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Deskripsi</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
              {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
        <option value="1" {{ (isset($product) && $product->status == 1) ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ (isset($product) && $product->status == 0) ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
    @error('status')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Gambar Produk</label>
    <input type="file" name="pictures[]" class="form-control @error('pictures.*') is-invalid @enderror"
           multiple {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}>
    @error('pictures.*')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($pictures) && $pictures->count() > 0)
        <div class="row mt-3">
            @foreach($pictures as $picture)
                <label>{{$picture->picture}}</label>
                <div class="col-md-3 mb-3 position-relative">
                    <img src="{{ $gambar }}" class="img-fluid" alt="Product Image">
                @if(!isset($viewMode) || !$viewMode)
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-picture"
                                data-picture-id="{{ $picture->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
