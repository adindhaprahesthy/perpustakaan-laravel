<?php

namespace App\Http\Controllers;

use App\Models\PengembalianBukumodel;
use App\Models\PeminjamanBukumodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianBukucontroller extends Controller
{
    //create data start
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_peminjaman_buku' => 'required'
        ]);

        if($validator->fails()){
            return Response() -> json($validator->errors());
        }

        $cek_kembali = PengembalianBukumodel::where('id_peminjaman_buku', $request->id_peminjaman_buku);
        if($cek_kembali->count() == 0){
            $dt_kembali= PeminjamanBukumodel::where('id_peminjaman_buku', $request->id_peminjaman_buku)->first();
            $tanggal_sekarang = Carbon::now()->format('Y-m-d');
            $tanggal_kembali = new Carbon ($dt_kembali->tanggal_sekarang);
            $dendaperhari = 1500;
            if(strtotime($tanggal_sekarang) > strtotime($tanggal_kembali)){
                $jumlah_hari = $tanggal_kembali->diff($tanggal_sekarang)->days;
                $denda = $jumlah_hari * $dendaperhari;
            }else {
                $denda = 0;
            }
            $save = PengembalianBukumodel::create([
                'id_peminjaman_buku' => $request->id_peminjaman_buku,
                'tanggal_pengembalian' => $tanggal_sekarang,
                'denda' => $denda
            ]);
            if ($save){
                $data['status'] = 1;
                $data['message'] = 'Berhasil Dikembalikan!';
            }else {
                $data['status'] = 0;
                $data['message'] = 'Pengembalian Gagal!';
            }
        }else {
            $data = ['status' => 0, 'message' => 'Sudah Pernah Dikembalikan!'];
        }
        return Response()->json($data);
    }
    //create data end

    //read data start
    public function show(){
        return PengembalianBukumodel::all();
    }

    public function detail($id){
        if(DB::table('pengembalian_buku')->where('id_pengembalian_buku', $id)->exists()){
            $detail = DB::table('pengembalian_buku')
            ->select('pengembalian_buku.*')
            ->join('peminjaman_buku', 'peminjaman_buku.id_peminjaman_buku', '=', 'pengembalian_buku.id_peminjaman_buku')
            ->where('id_pengembalian_buku', $id)
            ->get();
            return Response()->json($detail);
        }else{
            return Response()->json(['message' => 'Data Tidak Ditemukan']);
        }
    }
    //read data end

    //update data start
    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        [
            'id_peminjaman_buku' => 'required',
            'tanggal_pengembalian' => 'required',
            'denda' => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update=DB::table('pengembalian_buku')
        ->where('id_pengembalian_buku', '=', $id)
        ->update([
            'id_peminjaman_buku' => $request->id_peminjaman_buku,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'denda' => $request->denda
        ]);

        $data=PengembalianBukumodel::where('id_pengembalian_buku', '=', $id)->get();
        if($update){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success update data!',
                'data' => $data  
            ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Gagal updating data!'
            ]);
        }
    }
    //update data end

    //delete data start
    public function delete($id){
        $delete = DB::table('pengembalian_buku')
        ->where('id_pengembalian_buku', '=', $id)
        ->delete();

        if($delete){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes hapus data!'
        ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed hapus data!'
        ]);
        }

    }
    //delete data end
}