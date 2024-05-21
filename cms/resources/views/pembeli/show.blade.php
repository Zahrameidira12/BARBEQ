@extends('dashboard.layouts.mains')
@section('admin-magang')
<div class="container mt-4">
    <div class="card" style="max-width: 800px; margin: auto;">
        <div class="card-header">
            <h3>Detail Pembeli: {{ $pembeli->nama_pembeli }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3 mt-3">
                <div class="col-md-12 text-center">
                    {{-- <img src="{{ $pembeli->gambar }}" style="max-height: 300px" class="img-fluid mt-2" alt="{{ $pembeli->nama_pembeli }}"> --}}
                    <img src="{{ url('pembeli-images/'.$pembeli->gambar) }}" width="100" height="100" alt="User Image" style="float: left; margin-right: 10px;">

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>ID Pembeli:</strong></div>
                <div class="col-md-8">{{ $pembeli->id }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Nama Pembeli:</strong></div>
                <div class="col-md-8">{{ $pembeli->nama_pembeli }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Email:</strong></div>
                <div class="col-md-8">{{ $pembeli->email }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>No Tlp:</strong></div>
                <div class="col-md-8">{{ $pembeli->no_tlp }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"><strong>Alamat Pembeli:</strong></div>
                <div class="col-md-8">{{ $pembeli->alamat_pembeli }}</div>
            </div>
        </div>
    </div>
</div>
@endsection