@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pengelolaan Pengiriman') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('shipments.create') }}" class="btn btn-primary">
                    Tambah Pengiriman
                </a>
            </div>
        </div>
    </div>

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <div class="table-wrapper table-responsive">
                    <table class="table striped-table" id="dataTable">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th><h6>Order ID</h6></th>
                            <th><h6>Alamat Pengiriman</h6></th>
                            <th><h6>Status</h6></th>
                            <th><h6>Nomor Resi</h6></th>
                            <th><h6>Tanggal Pengiriman</h6></th>
                            <th><h6>Aksi</h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shipments as $shipment)
                            <tr>
                                <td><h6 class="text-sm">{{ $loop->iteration }}</h6></td>
                                <td><p>{{ $shipment->order_id }}</p></td>
                                <td><p>{{ $shipment->shipping_address }}</p></td>
                                <td><p>{{ ucfirst($shipment->shipping_status) }}</p></td>
                                <td><p>{{ $shipment->tracking_number }}</p></td>
                                <td><p>{{ $shipment->shipped_at->format('d M Y H:i') }}</p></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" class="d-inline">
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
                        {{ $shipments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
