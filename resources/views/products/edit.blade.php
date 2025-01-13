
@extends('layouts.app')

@section('content')
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>{{ isset($viewMode) && $viewMode ? 'Detail Produk' : 'Ubah Produk' }}</h2>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="card-styles">
        <div class="card-style-3 mb-30">
            <div class="card-content">
                @if(isset($viewMode) && !$viewMode)
                    <form id="editForm" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @endif

                        @include('products.form')

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
            const requiredFields = form.querySelectorAll('input[required], textarea[required], select[required]');

            // Function to check required fields and enable/disable the button
            function checkRequiredFields() {
                let allFilled = true;
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        allFilled = false;
                    }
                });
                saveButton.disabled = !allFilled;
            }

            // Run check initially and on each input change
            checkRequiredFields();
            requiredFields.forEach(field => {
                field.addEventListener('input', checkRequiredFields);
            });

            // Picture deletion handling
            const deletePictureButtons = document.querySelectorAll('.delete-picture');
            deletePictureButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pictureId = this.getAttribute('data-picture-id');
                    if(confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                        fetch(`/product/picture/${pictureId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if(data.success) {
                                    this.closest('.col-md-3').remove();
                                } else {
                                    alert('Gagal menghapus gambar');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat menghapus gambar');
                            });
                    }
                });
            });
        });

        // Show the modal confirmation
        function showConfirmationModal() {
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        }

        // Submit the form after confirmation
        function submitForm() {
            document.getElementById('editForm').submit();
        }
    </script>
@endsection
