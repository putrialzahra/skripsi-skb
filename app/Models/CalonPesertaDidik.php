<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonPesertaDidik extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'agama',
        'pekerjaan',
        'no_hp',
        'email',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'no_hp_ortu',
        'kk',
        'akta',
        'ijazah',
        'foto',
        'pernyataan',
    ];
}