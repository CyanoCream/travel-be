@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pengelolaan Role') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    Tambah Role
                </button>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    Filter
                </button>
            </div>
        </div>
    </div>

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <div class="table-wrapper table-responsive">
                    <table class="table striped-table" id="dataTableRole">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th><h6>Kode</h6></th>
                            <th><h6>Nama</h6></th>
                            <th><h6>Aksi</h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td><h6 class="text-sm">{{ $loop->iteration }}</h6></td>
                                <td><p>{{ $role->code }}</p></td>
                                <td><p>{{ $role->name }}</p></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pt-10 pb-10 d-flex flex-wrap justify-content-between">
                    <div class="left"></div>
                    <div class="right">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Role Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @include('master.role.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('roles.index') }}" method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pencarian</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                            <small class="form-text">Cari berdasarkan kode atau nama role</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
                $('#dataTableRole').DataTable();
            }
        )
    </script>
@endsection
