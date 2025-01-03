{{-- resources/views/users/form.blade.php --}}
<div class="mb-3">
    <label class="form-label required">Nama</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $user->name ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $user->email ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
    @error('email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nomor Telepon</label>
    <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
           value="{{ old('phone_number', $user->phone_number ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}>
    @error('phone_number')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nama Lengkap</label>
    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror"
           value="{{ old('fullname', $user->fullname ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}>
    @error('fullname')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nama Pengguna</label>
    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
           value="{{ old('username', $user->username ?? '') }}" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}>
    @error('username')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kata Sandi {{ isset($user) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</label>
    <input type="hidden" name="password" value="{{ $user->password }}"> {{-- Password lama sebagai default --}}
    <input type="password"
           name="password_new" {{-- Ganti name menjadi password_new --}}
           class="form-control @error('password') is-invalid @enderror"
           autocomplete="off"
        {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}>
    @error('password')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="address" class="form-control @error('address') is-invalid @enderror"
              rows="3" {{ isset($viewMode) && $viewMode ? 'disabled' : '' }}>{{ old('address', $user->address ?? '') }}</textarea>
    @error('address')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
