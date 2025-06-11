<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonPesertaDidik;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class CalonPesertaDidikController extends Controller
{
    public function create()
    {
        return view('ppdb.form');
    }

    public function store(Request $request)
    {
        // Ambil tahun akademik aktif
        $activeyear = AcademicYear::where('is_active', true)->first();

        if (!$activeyear) {
            return back()->withInput()
                         ->with('error', 'Tidak ada tahun akademik aktif.');
        }

        // Validasi input
        $validated = $request->validate([
            // Data Pribadi
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'agama' => 'required|string|max:20',
            'pekerjaan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:100|unique:calon_peserta_didiks,email',
            'kebangsaan' => 'required|string|max:3',
            'paket' => 'required|in:A,B,C',
            'nama_lembaga' => 'required|string',
            'alamat_lembaga' => 'required|string',

            // Data Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:100',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:100',
            'no_hp_ortu' => 'required|string|max:20',

            // File Upload
            'kk' => 'required|file|mimes:pdf|max:2048',
            'akta' => 'required|file|mimes:pdf|max:2048',
            'ijazah' => 'required|file|mimes:pdf|max:2048',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:1024',

            // Checkbox
            'pernyataan' => 'accepted'
        ]);

        try {
            $uploadPath = 'uploads/ppdb/' . date('Y/m/d');

            $filePaths = [];
            $fileFields = ['kk', 'akta', 'ijazah', 'foto'];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($uploadPath, $fileName, 'public');
                    $filePaths[$field] = $path;
                }
            }

            // Masukkan nilai pernyataan
            $validated['pernyataan'] = true;
            $validated['academic_year_id'] = $activeyear->id;

            $data = array_merge($validated, [
                'kk' => $filePaths['kk'] ?? null,
                'akta' => $filePaths['akta'] ?? null,
                'ijazah' => $filePaths['ijazah'] ?? null,
                'foto' => $filePaths['foto'] ?? null,
                'paket' => $validated['paket'],
                'status' => 'pending'
            ]);


            //dd($data);
            CalonPesertaDidik::create($data);

            return redirect()->route('ppdb.create')
                             ->with('success', 'Pendaftaran berhasil! Data Anda telah tersimpan.');

        } catch (\Exception $e) {
            if (isset($filePaths)) {
                foreach ($filePaths as $filePath) {
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }

            dd($e->getMessage());

            return back()->withInput()
                         ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}