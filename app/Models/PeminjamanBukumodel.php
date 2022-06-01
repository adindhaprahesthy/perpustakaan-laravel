<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBukumodel extends Model
{
    protected $table = 'peminjaman_buku';
    protected $primarykey = 'id_peminjaman_buku';
    public $timestamps = false;
    protected $fillable = ['id_siswa','tanggal_pinjam','tanggal_kembali'];

    use HasFactory;
}
