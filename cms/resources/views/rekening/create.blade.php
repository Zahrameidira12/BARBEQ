@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('rekening.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_bank">Nama Bank</label>
                    <input type="text" class="form-control" id="nama_bank" name="nama_bank">
                </div>
                <div class="form-group">
                    <label for="no_rek">No. Rekening</label>
                    <input type="text" class="form-control" id="no_rek" name="no_rek">
                </div>
                <div class="form-group">
                    <label for="nama_pemilik">Nama Pemilik</label>
                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik">
                </div>
                <button type="submit" class="btn btn-danger mt-3">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
