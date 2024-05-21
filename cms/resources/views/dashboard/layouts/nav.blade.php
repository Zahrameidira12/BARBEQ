<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Masukkan CSS Anda di sini -->
    <style>
        .nav-link.active {
            color: red !important;
        }
    </style>
</head>
<body>
    <!-- Isi Halaman Anda -->

    <!-- Sidebar dan konten Anda -->
    <aside id="sidebar" class="sidebar bg-danger d-flex flex-column">
        <ul class="sidebar-nav flex-grow-1" id="sidebar-nav">
            {{-- <li class="nav-item">
                <a class="nav-link text-black" href="/dashboard">
                    <i class="bi bi-grid text-black"></i>
                    <span>Dashboard</span>
                </a>
            </li> --}}

            <li class="nav-item ">
                <a class="nav-link text-black {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page"
                    href="/dashboard">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>

            <!-- End Dashboard Nav -->

            @can('superadmin')
            <li class="nav-item">
                <a class="nav-link text-black {{ Request::is('user*') ? 'active' : '' }}" href="/user">
                    <span data-feather="archive" class="align-text-bottom"></span>
                    Manage Admin
                </a>
            </li>
            @endcan

            @cannot('superadmin')
            <li class="nav-item">
                <a class="nav-link text-black {{ Request::is('produk*') ? 'active' : '' }}" href="/produk">
                    <span data-feather="archive" class="align-text-bottom"></span>
                    Produk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black {{ Request::is('kategori*') ? 'active' : '' }}" href="/categori">
                    <span data-feather="folder-plus" class="align-text-bottom"></span>
                    Kategori Produk
                </a>
            </li>
            @endcannot

            @can('admin')
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('user*') ? 'active' : '' }}" href="/penjual">
                    <span data-feather="user" class="align-text-bottom"></span>
                    Penjual
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('pembeli*') ? 'active' : '' }}" href="/pembeli">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Pembeli
                </a>
            </li>
            @endcan

            @can('admin')
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('all*') ? 'active' : '' }}" href="/all">
                    <span data-feather="clipboard" class="align-text-bottom"></span>
                    All Pesanan
                </a>
            </li>

            @endcan

            @cannot('superadmin')
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('pesanan*') ? 'active' : '' }}" href="/pesanan">
                    <span data-feather="check-circle" class="align-text-bottom"></span>
                    @if(auth()->user()->isadmin)
                        Verifikasi Pesanan
                    @else
                        Pesanan
                    @endif
                </a>
            </li>
            @endcannot



            @cannot('admin')
            @cannot('superadmin')
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('pengiriman*') ? 'active' : '' }}" href="/pengiriman">
                    <span data-feather="send" class="align-text-bottom"></span>
                    Pengiriman
                </a>
            </li>
            @endcannot
            @endcannot

            @cannot('superadmin')
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('keuangan*') ? 'active' : '' }}" href="/keuangan">
                    <span data-feather="dollar-sign" class="align-text-bottom"></span>
                    @if(auth()->user()->isadmin)
                        Verifikasi Money
                    @else
                        Pemasukan
                    @endif
                </a>
            </li>
            @can('admin')
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('banner*') ? 'active' : '' }}" href="/banner">
                    <span data-feather="image" class="align-text-bottom"></span>
                    Banner
                </a>
            </li>

            @endcan
            @endcannot

            @cannot('superadmin')
            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('setting*') ? 'active' : '' }}" href="/setting">
                    <span data-feather="settings" class="align-text-bottom"></span>
                    Setting
                </a>
            </li>
            @endcannot
        </ul>

        <ul class="sidebar-nav mt-auto">
            <li class="nav-item">
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="nav-link collapsed text-dark" style="border: none;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </aside><!-- End Sidebar-->

    <script>
        // Ambil semua elemen dengan kelas 'nav-link'
        var navLinks = document.querySelectorAll('.nav-link');

        // Loop melalui setiap elemen dan tambahkan event listener
        navLinks.forEach(function(navLink) {
            navLink.addEventListener('click', function() {
                // Setel warna teks menjadi merah saat tautan diklik
                this.style.color = 'red';

                // Setel kembali warna teks menjadi hitam setelah 1 detik
                setTimeout(function() {
                    navLink.style.color = 'black';
                }, 1000);
            });
        });
    </script>

</body>
</html>