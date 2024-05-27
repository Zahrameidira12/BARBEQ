@extends('dashboard.layouts.mains')
@section('admin-magang')
    <div class="row">

        <div class="col-lg-12 ">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Info!</strong> {{ session('success') }}
                </div>
            @endif
        </div>


    </div>
    {{-- <div class="container mt-1"> --}}
        <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
            <link rel="stylesheet" type="text/css" href="https:////cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" />

            <table id="pembeli" class="table table-striped" style="width:100%">

                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Pembeli</th>
                        <th scope="col">No Tlp</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pembelis as $item)
                        <tr class="">
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->no_tlp }}</td>
                            <td>
                                @if ($item->gambar)
                                <img src="{{ $item->gambar }}" style="max-height: 150px" class="img-fluid mt-2 d-block"
                                alt="{{ $item->name }}">
                            @else
                                <img src="https://source.unsplash.com/1200x400? {{ $item->name }}" class="img-fluid mt-2"
                                alt="{{ $item->name}}">
                                @endif
                            </td>
                            @can('admin')
                            <td>
                                <a href="{{ route('pembeli.show', $item->id) }}" class="btn btn-danger btn-sm" style="width: 30px; height: 30px;" ><i class="bi bi-eye-fill"></i></a>
                                <form action="/pembeli/{{ $item->kode }}" method="post" class="d-inline" >
                                    <!-- Timpa method post menjadi delete -->
                                    @method('delete')
                                    @csrf
                                    <button type="submit" onclick="return confirm('Apakah anda yakin ingin hapus pembeli ? {{ $item->name }}')" class="badge bg-danger border-0" style="width: 30px; height: 30px;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                            @endcan
                        </tr>
                    @endforeach

                    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
                    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>

                    <script type="text/javascript" >
                    let table = new DataTable('#pembeli');
                    </script>
            </tbody>
            </table>
        </div>
    {{-- </div> --}}
    {{-- <div class="d-flex justify-content-end"> --}}
        <!--Menampilkan page/halaman-->
        {{-- {{ $produks->links() }} --}}
        {{-- {{ $pembelis->links('pagination::bootstrap-5') }} --}}
    </div>
@endsection
