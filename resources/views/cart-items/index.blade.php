{{-- index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Pengelolaan Keranjang') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    Tambah Item
                </button>
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
                            <th><h6>Produk</h6></th>
                            <th><h6>Harga</h6></th>
                            <th><h6>Jumlah</h6></th>
                            <th><h6>Total</h6></th>
                            <th><h6>Aksi</h6></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td><h6 class="text-sm">{{ $loop->iteration }}</h6></td>
                                <td><p>{{ $item->product->product_name }}</p></td>
                                <td><p>{{ number_format($item->price, 0, ',', '.') }}</p></td>
                                <td><p>{{ $item->quantity }}</p></td>
                                <td><p>{{ number_format($item->total_price, 0, ',', '.') }}</p></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('cart-items.show', $item) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('cart-items.edit', $item) }}" class="btn btn-sm btn-warning me-1" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cart-items.destroy', $item) }}" method="POST" class="d-inline">
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
                    <div class="left">
                        <h5>Total Keranjang: Rp <span id="cartTotal">0</span></h5>
                    </div>
                    <div class="right">
                        {{ $cartItems->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('cart-items.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Item ke Keranjang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @include('cart-items.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
            updateCartTotal();
        });

        function updateCartTotal() {
            $.ajax({
                url: '{{ route("cart-items.getCartTotal") }}',
                method: 'GET',
                success: function(response) {
                    $('#cartTotal').text(new Intl.NumberFormat('id-ID').format(response.total));
                },
                error: function(error) {
                    console.error('Error fetching cart total:', error);
                }
            });
        }
    </script>
@endsection
