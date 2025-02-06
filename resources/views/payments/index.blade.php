@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pengelolaan Pembayaran') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('payments.create') }}" class="btn btn-primary">
                    Tambah Pembayaran
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
                            <th><h6>Metode Pembayaran</h6></th>
                            <th><h6>Jumlah</h6></th>
                            <th><h6>Status</h6></th>
                            <th><h6>Tanggal Pembayaran</h6></th>
                            <th><h6>Aksi</h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td><h6 class="text-sm">{{ $loop->iteration }}</h6></td>
                                <td><p>{{ $payment->order_id }}</p></td>
                                <td><p>{{ ucfirst($payment->payment_method) }}</p></td>
                                <td><p>{{ number_format($payment->amount, 2) }}</p></td>
                                <td>
                                    <p>
                                        @if($payment->payment_status == 1)
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($payment->payment_status == 2)
                                            <span class="badge bg-success">Success</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </p>
                                </td>
                                <td><p>{{ $payment->payment_date->format('d M Y H:i') }}</p></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
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
                        {{ $payments->links() }}
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
