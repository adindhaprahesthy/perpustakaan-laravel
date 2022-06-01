<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjamanBukumodel extends Model
{
    protected $table = 'detail_peminjaman_buku';
    public $timestamps = false;
    protected $fillable = ['id_peminjaman_buku','id_buku','qty'];

    use HasFactory;
}