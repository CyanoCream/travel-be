@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ isset($viewMode) && $viewMode ? 'Detail Kota' : 'Ubah Kota' }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('cities.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                @if(isset($viewMode) && !$viewMode)
                    <form id="editForm" action="{{ route('cities.update', $city) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @endif

                        @include('master.cities.form')

                        @if(isset($viewMode) && !$viewMode)
                            <div class="text-end">
                                <button type="button" class="btn btn-primary" onclick="showConfirmationModal()">Simpan Perubahan</button>
                            </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Confirmation -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Simpan Perubahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menyimpan perubahan ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Ya, Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById('editForm');
            const saveButton = document.querySelector('#editForm button[type="button"]');
            const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');

            function checkRequiredFields() {
                let allFilled = true;
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        allFilled = false;
                    }
                });
                saveButton.disabled = !allFilled;
            }

            checkRequiredFields();
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
            });
        });

        function showConfirmationModal() {
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        }

        function submitForm() {
            document.getElementById('editForm').submit();
        }
    </script>
@endsection
