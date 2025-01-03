<div class="mb-3">
    <label class="form-label required">Nama Kota</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $city->name ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Provinsi</label>
    <select name="province_id" class="form-control @error('province_id') is-invalid @enderror"
            {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
        <option value="">Pilih Provinsi</option>
        @foreach($provinces as $province)
            <option value="{{ $province->id }}"
                {{ (old('province_id', $city->province_id ?? '') == $province->id) ? 'selected' : '' }}>
                {{ $province->name }}
            </option>
        @endforeach
    </select>
    @error('province_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
