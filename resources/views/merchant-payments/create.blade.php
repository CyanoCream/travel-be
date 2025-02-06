@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ __('Tambah Pembayaran Merchant') }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('merchant-payments.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="card-styles">  
        <div class="card-style-3 mb-30">
            <div class="card-content">
                <form action="{{ route('merchant-payments.store') }}" method="POST">
                    @csrf
                    @include('merchant-payments.form')
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
