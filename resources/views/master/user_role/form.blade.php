<div class="mb-3">
    <label class="form-label required">Pengguna</label>
    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror"
            {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
        <option value="">Pilih Pengguna</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                {{ (old('user_id', $roleCode->user_id ?? '') == $user->id) ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('user_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label required">Role</label>
    <select name="role_code" class="form-select @error('role_code') is-invalid @enderror"
            {{ isset($viewMode) && $viewMode ? 'disabled' : '' }} required>
        <option value="">Pilih Role</option>
        @foreach($roles as $role)
            <option value="{{ $role->code }}"
                {{ (old('role_code', $roleCode->role_code ?? '') == $role->code) ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>
    @error('role_code')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
