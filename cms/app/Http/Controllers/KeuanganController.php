<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Bayar;
use App\Models\Statusverifikasi;
use App\Models\Rekening;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pembeli;
use App\Models\Pesanan;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KeuanganController extends Controller
{
    public function index()
    {
        // Mendapatkan role user yang sedang login
        $isAdmin = auth()->user()->isadmin;

        // Query untuk mendapatkan pesanan sesuai dengan role user
        if ($isAdmin) {
            $pesanans = Pesanan::where('status_id', 3)
                                ->where('bayar_id', 2)
                                ->get();
        } else {
            $pesanans = Pesanan::where('user_id', auth()->id())
                                ->where('status_id', 3)
                                ->get();
        }

        // Mengambil relasi untuk diperlihatkan di view
        $pesanans->load(['produk', 'pembeli', 'statusverifikasi', 'rekening', 'bayar', 'status', 'user']);

        // Mengembalikan view bersama data yang diperlukan
        return view('keuangan.index', [
            'title' => 'Pemasukan',
            'pesanans' => $pesanans,
            'pembelis' => Pembeli::all(),
            'statusverifikasis' => Statusverifikasi::all(),
            'users' => User::all(),
            'produks' => Produk::all(),
            'rekenings' => Rekening::all(),
            'bayars' => Bayar::all(),
            'statuss' => Status::all(),
        ]);
    }

    function store(Request $request)
    {
        $param = $request->except('_token', 'gambar');
        $validator = Validator::make($param, [
            'gambar' => 'image|file|max:1024',
            'produk_id' => 'required',
            'pembeli_id' => 'required',
            'user_id' => 'required',
            'status_id' => 'exists:statuss,id',
            'bayar_id' => 'exists:bayarss,id',
            // 'bayar_id' => '',
            'statusverifikasi_id' =>'exists:statusverifikasis,id',
            'rekening_id' => 'required',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Ambil rekening_id berdasarkan user_id yang ada dalam pesanan
        $rekening = Rekening::where('user_id', $request->input('user_id'))->first();

        if (!$rekening) {
            return back()->with('error', 'Rekening tidak ditemukan.');
        }

        $param['rekening_id'] = $rekening->id; // Set rekening_id dengan id rekening yang ditemukan

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('setor-images'), $filename);
            $param['gambar'] = 'setor-images/' . $filename;
        }

        $create = Pesanan::create($param);

        if ($create) {
            return redirect()->route('keuangan.index')->with('success', 'pesanan Created');
        }

        return back()->with('error', 'Oops, something went wrong!');
    }


    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('keuangan.update', ['title' => 'Edit Setor', 'pesanan' => $pesanan]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'image|file|max:1024',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pesanan = Pesanan::findOrFail($id);
        $param = $request->except('_method', '_token', 'gambar', 'oldImage');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('setor-images'), $filename);
            $param['gambar'] = 'setor-images/' . $filename;
        }

        $update = $pesanan->update($param);

        if ($update) {
            return redirect()->route('keuangan.index')->with('success', 'Setor Updated');
        }

        return back()->with('error', 'Not Updated');
    }

    public function destroy($id)
    {
        Pesanan::where($id)->delete();
        return redirect()->route('keuangan.index')->with('success', 'Pesanan Berhasil dihapus');
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['produk', 'pembeli', 'statusverifikasi', 'user', 'bayar', 'status','rekening'])->findOrFail($id);
        return view('keuangan.show', ['title' => 'Detail ', 'pesanan' => $pesanan]);
    }

    public function fnGetData(Request $request)
    {
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data = Pesanan::where('id', '!=', 1)->with(['produk', 'pembeli', 'statusverifikasi', 'rekening', 'bayar', 'status', 'user']);

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $keyword = $request->input('search')['value'];
            $data = $data->where('id', 'LIKE', '%' . $keyword . '%')
                ->orWhereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%');
                });
        }

        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir'])->paginate($limit);

        return DataTables::of($data)
            ->skipPaging()
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->addColumn('gambar', function ($data) {
                return '<img src="' . asset($data->gambar) . '" class="img-circle" style="width:50px">';
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="admin/' . $data->name . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->user_id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['gambar', 'action'])
            ->make(true);
    }
}