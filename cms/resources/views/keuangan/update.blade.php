@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="row">
    <div class="col-lg-6">
        @if (Session::has('error'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
        @endif
        <form action="{{ route('keuangan.update', $pesanan->id) }}" method="post" enctype="multipart/form-data" class="tambah-setor" novalidate>
            @csrf
            @method('put') <!-- Tambahkan ini untuk menentukan method PUT -->
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <img src="" id="img-preview" class="img-preview img-fluid w-30" alt="">
                <input type="file" onchange="previewImage()" class="form-control @error('gambar') is-invalid @enderror" accept="setor-images/*" name="gambar" id="gambar" placeholder="" aria-describedby="fileHelpId">
                <div id="fileHelpId" class="form-text text-danger">Format jpg, jpeg, png</div>
                <div class="invalid-feedback">
                    {{ $errors->has('gambar') ? $errors->first('gambar') : '' }}
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100 mb-3">SIMPAN</button>

        </form>
    </div>
</div>

<script>
    // Fungsi preview gambar
    function previewImage() {
        const imgPreview = document.querySelector('#img-preview');
        const gambarInput = document.querySelector('#gambar');

        const fileGambar = new FileReader();
        fileGambar.readAsDataURL(gambarInput.files[0]);

        fileGambar.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }

    // Validasi form
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.tambah-setor')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection
