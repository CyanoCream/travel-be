<div class="mb-3">
    <label class="form-label required">Nama</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $merchant->name ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Kota</label>
    <select name="city_id" class="form-control @error('city_id') is-invalid @enderror" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
        <option value="">Pilih Kota</option>
        @foreach($cities as $city)
            <option value="{{ $city->id }}" {{ (isset($merchant) && $merchant->city_id == $city->id) ? 'selected' : '' }}>
                {{ $city->name }}
            </option>
        @endforeach
    </select>
    @error('city_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Alamat</label>
    <textarea name="address" class="form-control @error('address') is-invalid @enderror"
              {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>{{ old('address', $merchant->address ?? '') }}</textarea>
    @error('address')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Kontak Person</label>
    <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror"
           value="{{ old('contact_person', $merchant->contact_person ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('contact_person')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Status</label>
    <select name="status" class="form-control @error('status') is-invalid @enderror" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
        <option value="1" {{ (isset($merchant) && $merchant->status == 1) ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ (isset($merchant) && $merchant->status == 0) ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
    @error('status')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Foto Display</label>
    <input type="file" name="display_picture" class="form-control @error('display_picture') is-invalid @enderror"
        {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}>
    @error('display_picture')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($merchant) && $merchant->display_picture && isset($picture))
        <div class="mt-3">
            <img src="{{ $picture }}" class="img-fluid" style="max-height: 200px" alt="Display Picture">
            @if(!isset($viewMode) || !$viewMode)
                <button type="button" class="btn btn-danger btn-sm delete-picture"
                        data-merchant-id="{{ $merchant->id }}">
                    <i class="fa fa-trash"></i> Hapus Foto
                </button>
            @endif
        </div>
    @endif
</div>
