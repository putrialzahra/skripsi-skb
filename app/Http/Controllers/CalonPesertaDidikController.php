<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonPesertaDidik;
use Illuminate\Support\Facades\Redirect;

class CalonPesertaDidikController extends Controller
{
    // Menampilkan form PPDB
    public function create()
    {
        return view('ppdb.form');
    }

    // Menyimpan data dari form
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'pekerjaan' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'nama_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nama_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'no_hp_ortu' => 'required',
            'kk' => 'nullable',
            'akta' => 'nullable',
            'ijazah' => 'nullable',
            'foto' => 'nullable',
            'pernyataan' => 'required',
        ]);

        // Simpan data ke database
        CalonPesertaDidik::create($request->all());

        // Redirect dengan pesan sukses
        return Redirect::route('ppdb.create')->with('success', 'Pendaftaran berhasil!');
    }
}