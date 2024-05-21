<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\Pesanan;
use App\Models\Statusverifikasi;
use App\Models\Rekening;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Pesanan::query();

        // Filter pesanan berdasarkan peran pengguna dan status pembayaran serta verifikasi
        if ($user->isadmin) {
            // Jika user adalah admin, tampilkan pesanan dengan bayar_id selain 1, seperti 2,3,4 dll
            $query->where('bayar_id', '!=', 1)
                  ->whereIn('statusverifikasi_id', [0, 1]);
        } else {
            // Jika user adalah user biasa, tampilkan pesanan dengan bayar_id 1 dan statusverifikasi_id 0 atau 1,
            // atau pesanan dengan bayar_id 2 dan statusverifikasi_id 2
            $query->where(function ($query) {
                      $query->where('bayar_id', 1)
                            ->whereIn('statusverifikasi_id', [0, 1]);
                    })
                    ->orWhere(function ($query) {
                        $query->where('bayar_id', '!=', 1)
                            ->where('statusverifikasi_id', 2);
                    });
        }

        $pesanans = $query->with(['produk', 'pembeli', 'statusverifikasi', 'rekening', 'bayar'])->get();

        return view('pesanan.index', [
            'title' => 'Pesanan',
            'pesanans' => $pesanans,
            'pembelis' => Pembeli::all(),
            'statusverifikasis' => Statusverifikasi::all(),
            'users' => User::all(),
            'produks' => Produk::all(),
            'rekenings' => Rekening::all(),
            'bayars' => Bayar::all(),

        ]);
    }


    public function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');

        // Validasi
        $validator = Validator::make($param, [
            'gambar' => 'image|file|max:1024',
            'harga_total' => 'required',
            'jumlah_produk' => 'required',
            'produk_id' => 'required',
            'pembeli_id' => 'required',
            'user_id' => 'required',
            'status_id' => 'exists:statuss,id',
            'bayar_id' => 'required',
            'statusverifikasi_id' =>'exists:statusverifikasis,id',
            'rekening_id' => 'required',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanans = Pesanan::create($param);

        if ($pesanans) {
            return redirect('pesanan')->with('success', 'Pesanan Created');
        }

        return back()->with('error', 'Oops, something went wrong!');
    }

    public function update(Request $request, $id)
    {
        $param = $request->except('_method', '_token', 'gambar', 'oldImage');

        // Validasi
        $validator = Validator::make($param, [
            'bayar_id' => '',
            'statusverifikasi_id' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $update = Pesanan::where('id', $id)->update($param);

        if ($update) {
            return redirect('pesanan')->with('success', 'Pesanan Updated');
        }

        return back()->with('error', 'Pesanan not Updated');
    }


    public function updateStatusverifikasi(Request $request, $id)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'statusverifikasi_id' => 'required|exists:statusverifikasis,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->statusverifikasi_id = $request->statusverifikasi_id;

        if ($pesanan->save()) {
            return redirect('pesanan')->with('success', 'Status verifikasi berhasil diperbarui');
        }

        return back()->with('error', 'Gagal memperbarui status verifikasi');
    }


    public function destroy($id)
    {
        Pesanan::where('id', $id)->delete();
        return redirect('pesanan')->with('success', 'Pesanan Berhasil dibatalkan');
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['produk', 'pembeli', 'statusverifikasi', 'user', 'bayar'])->findOrFail($id);
        return view('pesanan.show', ['title' => 'Detail Pesanan', 'pesanan' => $pesanan]);
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data = Pesanan::query();

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('id', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('produk_id', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('pembeli_id', 'LIKE', '%' . $request->keyword . '%')
                ->orWhere('user_id', 'LIKE', '%' . $request->keyword . '%');
        }

        //Setting Limit
        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir'])
            ->paginate($limit);

        return DataTables::of($data)
            ->skipPaging()
            ->make(true);
    }
}
