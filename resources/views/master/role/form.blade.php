<div class="mb-3">
    <label class="form-label required">Kode Role</label>
    <input type="text" name="code"
           class="form-control @error('code') is-invalid @enderror"
           value="{{ old('code', $role->code ?? '') }}"
           {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}
           required>
    @error('code')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Nama Role</label>
    <input type="text" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $role->name ?? '') }}"
           {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}
           required>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
