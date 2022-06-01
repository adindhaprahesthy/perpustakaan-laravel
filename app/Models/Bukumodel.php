<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bukumodel extends Model
{
    protected $table = 'buku';
    protected $primarykey = 'id_buku';
    public $timestamps = false;
    protected $fillable = ['nama_buku','cover_buku','pengarang','deskripsi'];

    use HasFactory;
}
