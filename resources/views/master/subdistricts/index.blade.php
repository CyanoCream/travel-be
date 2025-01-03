@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pengelolaan Kecamatan') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    Tambah Kecamatan
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
                    <table class="table striped-table" id="dataTableSubdistrict">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th><h6>Nama Kecamatan</h6></th>
                            <th><h6>Kota</h6></th>
                            <th><h6>Aksi</h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subdistricts as $subdistrict)
                            <tr>
                                <td><h6 class="text-sm">{{ $loop->iteration }}</h6></td>
                                <td><p>{{ $subdistrict->name }}</p></td>
                                <td><p>{{ $subdistrict->city->name }}</p></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('subdistricts.show', $subdistrict) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('subdistricts.edit', $subdistrict) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('subdistricts.destroy', $subdistrict) }}" method="POST" class="d-inline">
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
                        {{ $subdistricts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('subdistricts.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kecamatan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @include('master.subdistricts.form')
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
                <form action="{{ route('subdistricts.index') }}" method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Kecamatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pencarian</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                            <small class="form-text">Cari berdasarkan nama kecamatan</small>
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
                $('#dataTableSubdistrict').DataTable();
            }
        )
    </script>
@endsection
