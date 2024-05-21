@extends('dashboard.layouts.mains')
@section('admin-magang')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>

    <body>


        <section class="section dashboard">

            <div class="row">

                <div class="col-lg-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Info!</strong> {{ session('success') }}
                        </div>
                    @endif
                </div>

            </div>
            <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
                <link rel="stylesheet" type="text/css"
                    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
                <link rel="stylesheet" type="text/css"
                    href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
                <link rel="stylesheet" type="text/css"
                    href="https:////cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

                <table id="pengiriman" class="table table-striped" style="width:100%">


                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            {{-- <th scope="col">Kode pengiriman</th> --}}
                            <th scope="col">Nama Pembeli</th>
                            <th scope="col">Produk</th>
                            <th scope="col">harga</th>
                            {{-- <th scope="col">jumlah produk</th> --}}
                            {{-- <th scope="col">Cara bayar</th> --}}
                            <th scope="col">Alamat Tujuan(Pembeli)</th>
                            <th scope="col">No tlp</th>
                            @can('admin')
                                <th scope="col">alamat pengirim</th>
                            @endcan
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pengirimans as $item)
                            <tr class="">
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $item->pembeli ? $item->pembeli->nama_pembeli : 'pembeli tidak ada' }}</td>
                                <td>{{ $item->produk ? $item->produk->nama_produk : 'produk tidak tersedia' }}</td>
                                <td>{{ $item->pesanan ? $item->pesanan->harga_total : 'harga tidak ada' }}</td>
                                {{-- <td>{{ $item->pesanan ? $item->pesanan->jumlah_produk : 'jumlah tidak ada' }}</td> --}}
                                {{-- <td>{{ $item->bayar ? $item->bayar->cara_bayar : 'bayar tidak tersedia' }}</td> --}}
                                <td>{{ $item->pembeli ? $item->pembeli->alamat_pembeli : 'alamat tidak ada' }}</td>
                                <td>{{ $item->pembeli ? $item->pembeli->no_tlp : 'no tlp tidak ada' }}</td>
                                @can('admin')
                                    <td>{{ $item->user ? $item->user->alamat : 'alamat pengirim tidak ada' }}</td>
                                @endcan

                                <td>

                                    <form action="{{ route('pengiriman.updateStatus', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select class="form-select form-select-md" name="status_id" id="status_id">
                                            @foreach ($statuss as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ $item->status_id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    </form>

                                </td>
                                <td>
                                    <a href="{{ route('pengiriman.show', $item->id) }}" class="btn btn-danger btn-sm" style="width: 30px; height: 30px;"><i class="bi bi-eye-fill"></i></a>
                                </td>


                                {{-- @endcan --}}
                            </tr>
                        @endforeach

                        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
                        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
                        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>

                        <script type="text/javascript">
                            let table = new DataTable('#pengiriman');
                        </script>
                    </tbody>

                </table>

                </script>
            </div>
            </div>

            {{-- <div class="d-flex justify-content-end"> --}}
            <!--Menampilkan page/halaman-->
            {{-- {{ $produks->links() }} --}}
            {{-- {{ $pengirimans->links('pagination::bootstrap-5') }} --}}
            </div>
        @endsection
