@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pengelolaan Provinsi') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    Tambah Provinsi
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
                    <table class="table striped-table" id="dataTableProvince">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th><h6>Nama Provinsi</h6></th>
                            <th><h6>Aksi</h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($provinces as $province)
                            <tr>
                                <td><h6 class="text-sm">{{ $loop->iteration }}</h6></td>
                                <td><p>{{ $province->name }}</p></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('provinces.show', $province) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('provinces.edit', $province) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('provinces.destroy', $province) }}" method="POST" class="d-inline">
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
                        {{ $provinces->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('provinces.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Provinsi Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @include('master.provinces.form')
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
                <form action="{{ route('provinces.index') }}" method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Provinsi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pencarian</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                            <small class="form-text">Cari berdasarkan nama provinsi</small>
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
                $('#dataTableProvince').DataTable();
            }
        )
    </script>
@endsection
