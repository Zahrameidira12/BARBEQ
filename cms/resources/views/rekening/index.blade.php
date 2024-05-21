@extends('dashboard.layouts.mains')

@section('admin-magang')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(auth()->user()->isadmin || $rekenings->count() == 0)
                <a href="{{ route('rekening.create') }}" class="btn btn-danger">Tambah Rekening</a>
            @else
                <div class="alert alert-warning">
                    Anda hanya diperbolehkan memiliki satu rekening.
                </div>
            @endif

            <br><br>
            <table class="table table-bordered">
                <tr>
                    <th>Nama Bank</th>
                    <th>No. Rekening</th>
                    <th>Nama Pemilik</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($rekenings as $rekening)
                <tr>
                    <td>{{ $rekening->nama_bank }}</td>
                    <td>{{ $rekening->no_rek }}</td>
                    <td>{{ $rekening->nama_pemilik }}</td>
                    <td>
                        <form action="{{ route('rekening.destroy', $rekening->id) }}" method="POST">
                            <a class="btn btn-primary" href="{{ route('rekening.edit', $rekening->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
