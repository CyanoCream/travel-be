@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pengelolaan Pembayaran Merchant') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('merchant-payments.create') }}" class="btn btn-primary">
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
                            <th><h6>Merchant</h6></th>
                            <th><h6>Order ID</h6></th>
                            <th><h6>Amount</h6></th>
                            <th><h6>Payment Date</h6></th>
                            <th><h6>Aksi</h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td><h6 class="text-sm">{{ $loop->iteration }}</h6></td>
                                <td><p>{{ $payment->merchant->name }}</p></td>
                                <td><p>{{ $payment->order_id }}</p></td>
                                <td><p>{{ number_format($payment->amount, 2) }}</p></td>
                                <td><p>{{ $payment->payment_date }}</p></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('merchant-payments.show', $payment) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('merchant-payments.edit', $payment) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('merchant-payments.destroy', $payment) }}" method="POST" class="d-inline">
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
