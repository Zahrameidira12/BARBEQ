@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="container mt-4">
        <div class="card" style="max-width: 800px; margin: auto;">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 mt-4">
                        <strong>
                            @if (auth()->user()->isadmin)
                                Bukti Setor
                            @else
                                Bukti Pemasukan/TF dari Admin
                            @endif
                        </strong>
                    </div>
                    <div class="col-md-4 mt-4">
                        @if ($pesanan->gambar)
                            <img src="{{ asset($pesanan->gambar) }}" alt="Bukti setor" width="200" height="150"
                                alt="User Image" style="float: left; margin-center: 10px;">
                        @else
                            tidak ada setor
                        @endif
                    </div>
                </div>

                @can('admin')
                    <div class="row mb-3">
                        @if (Session::has('error'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
                        @endif
                        <form action="{{ route('keuangan.update', $pesanan->id) }}" method="post" enctype="multipart/form-data"
                            class="tambah-setor" novalidate>
                            @csrf
                            @method('put') <!-- Tambahkan ini untuk menentukan method PUT -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <img src="" id="img-preview" class="img-preview img-fluid w-30" alt="">
                                <input type="file" onchange="previewImage()"
                                    class="form-control @error('gambar') is-invalid @enderror" accept="setor-images/*"
                                    name="gambar" id="gambar" placeholder="" aria-describedby="fileHelpId">
                                <div id="fileHelpId" class="form-text text-danger">Format jpg, jpeg, png</div>
                                <div class="invalid-feedback">
                                    {{ $errors->has('gambar') ? $errors->first('gambar') : '' }}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 mb-3">SIMPAN</button>

                        </form>
                    </div>
                @endcan

                <div class="row mb-3 mt-4">
                    <div class="col-md-4"><strong>ID Pesanan:</strong></div>
                    <div class="col-md-8">{{ $pesanan->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Rekening Penjual:</strong></div>
                    <div class="col-md-8">
                        @if ($pesanan->rekening)
                            {{ $pesanan->rekening->no_rek }}
                        @else
                            Rekening tidak ditemukan
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Cara Bayar:</strong></div>
                    <div class="col-md-8">{{ $pesanan->bayar->cara_bayar }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Status:</strong></div>
                    <div class="col-md-8">{{ $pesanan->statusverifikasi->statusverifikasi }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Status Pengiriman:</strong></div>
                    <div class="col-md-8">{{ $pesanan->status->status }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4"><strong>Penjual:</strong></div>
                    <div class="col-md-8">{{ $pesanan->user->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>No tlp Penjual:</strong></div>
                    <div class="col-md-8">{{ $pesanan->user->no_tlp }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Pembeli:</strong></div>
                    <div class="col-md-8">{{ $pesanan->pembeli->nama_pembeli }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>No tlp Pembeli:</strong></div>
                    <div class="col-md-8">{{ $pesanan->pembeli->no_tlp }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Alamat Pembeli:</strong></div>
                    <div class="col-md-8">{{ $pesanan->pembeli->alamat_pembeli }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nama Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->produk->nama_produk }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Jumlah Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->jumlah_produk }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Harga:</strong></div>
                    <div class="col-md-8">{{ $pesanan->harga_total }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>ID Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->produk->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Kode Produk:</strong></div>
                    <div class="col-md-8">{{ $pesanan->produk->kode }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Kategori:</strong></div>
                    <div class="col-md-8">{{ $pesanan->produk->kategori->kategori }}</div>
                </div>


            </div>




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
