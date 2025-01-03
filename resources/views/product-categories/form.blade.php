<div class="mb-3">
    <label class="form-label required">Nama Kategori</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $productCategory->name ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Deskripsi</label>
    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
           value="{{ old('description', $productCategory->description ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
