@extends('dashboard.layouts.mains')
@section('admin-magang')
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
        <div class="table-responsive-lg">
            <!-- Stylesheets -->
            <link rel="stylesheet" type="text/css"
                href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
            <link rel="stylesheet" type="text/css"
                href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

            <!-- Table -->
            <table id="pesanan" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        @can('admin')
                            <th scope="col">Penjual</th>
                        @endcan
                        @cannot('admin')
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga total</th>
                            <th scope="col">jumlah produk</th>
                            <th scope="col">Status</th>
                        @endcannot
                        <th scope="col">cara transaksi</th>
                        <th scope="col">
                            @if (auth()->user()->isadmin)
                                bukti setor
                            @else
                                Pemasukan
                            @endif
                        </th>
                        @can('admin')
                            <th scope="col">nama bank</th>
                            <th scope="col">rek penjual</th>
                        @endcan
                        {{-- @can('admin') --}}
                            <th scope="col">Action</th>
                        {{-- @endcan --}}
                        {{-- <th scope="col">#</th> --}}
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pesanans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @can('admin')
                                <td>{{ $item->user ? $item->user->name : 'Penjual tidak tersedia' }}</td>
                            @endcan
                            @cannot('admin')
                                <td>{{ $item->produk ? $item->produk->nama_produk : 'Produk tidak tersedia' }}</td>
                                <td>{{ $item->pesanan ? $item->pesanan->harga_total : 'harga tidak ada' }}</td>
                                <td>{{ $item->pesanan ? $item->pesanan->jumlah_produk : 'jumlah tidak ada' }}</td>
                                <td>{{ $item->statusverifikasi ? $item->statusverifikasi->statusverifikasi : 'Verifikasi tidak tersedia' }}
                                </td>
                            @endcannot
                            <td>{{ $item->bayar ? $item->bayar->cara_bayar : ' tidak tersedia' }}</td>

                            <td>
                                @if ($item->gambar)
                                    <img src="{{ asset($item->gambar) }}" alt="Bukti setor" style="max-height: 100px"
                                        class="img-fluid mt-2 d-block">
                                @else
                                    tidak ada setor
                                @endif
                            </td>
                            @can('admin')
                                <td>{{ $item->rekening ? $item->rekening->nama_bank : 'Rekening tidak tersedia' }}</td>
                                <td>{{ $item->rekening ? $item->rekening->no_rek : 'Rekening tidak tersedia' }}</td>
                            @endcan

                                <td style="display: flex; align-items: center;">
                                    <a href="{{ route('keuangan.show', $item->id) }}" class="btn btn-danger btn-sm"
                                        style="width: 30px; height: 30px;"><i class="bi bi-wallet"></i></a>
                                    {{-- <a href="{{ route('keuangan.edit', $item->id) }}" class="btn btn-danger btn-sm" style="width: 30px; height: 30px;"><i class="bi bi-cash-coin"></i></a> --}}
                                    @can('admin')
                                    <form action="{{ route('keuangan.destroy', $item->id) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Apakah anda yakin ingin batalkan pesanan ? {{ $item->pembeli->nama_pembeli }}')"
                                            class="badge bg-danger border-0" style="width: 30px; height: 30px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @endcan



                                </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Scripts -->
            <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
            <script type="text/javascript">
                let table = new DataTable('#pesanan');
            </script>
        </div>
    </div>
@endsection
