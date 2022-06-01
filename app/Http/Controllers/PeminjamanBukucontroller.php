<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBukumodel;
use App\Models\DetailPeminjamanBukumodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookBorrowController extends Controller
{
    //create data start 
    public function store(Request $request)
    {
        //request data to use
        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali'  => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return Response() -> json($validator->errors());
        }

        $peminjaman_buku = new PeminjamanBukumodel();
        $peminjaman_buku->id_siswa = $request->id_siswa;
        $peminjaman_buku->tanggal_pinjam = $request->tanggal_pinjam;
        $peminjaman_buku->tanggal_kembali = $request->tanggal_kembali;
        $peminjaman_buku->save();

        //insert detail peminjaman
        for($i = 0; $i < count($request->detail); $i++){
            $detail_peminjaman_buku = new DetailPeminjamanBukumodel();
            $detail_peminjaman_buku->id_peminjaman_buku = $peminjaman_buku->id_peminjaman_buku;
            $detail_peminjaman_buku->id_buku = $request->detail[$i]['id_buku'];
            $detail_peminjaman_buku->qty = $request->detail[$i]['qty'];
            $detail_peminjaman_buku->save();
        }

        if($peminjaman_buku && $detail_peminjaman_buku){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success!'
            ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed!'
            ]);
        }
    }
    //create data end

    //read data start
    public function show(){
        return PeminjamanBukumodel::with(['siswa', 'siswa.kelas'])->get();
    }

    public function detail($id){
        if(DB::table('peminjaman_buku')->where('id_peminjaman_buku', $id)->exists()){
            $detail_peminjaman_buku = DB::table('peminjaman_buku')
            ->select('peminjaman_buku.id_peminjaman_buku', 'peminjaman_buku.id_siswa', 'siswa.nama_siswa', 'peminjaman_buku.tanggal_pinjam', 'peminjaman_buku.tanggal_kembali')
            ->join('siswa', 'siswa.id_siswa', '=', 'peminjaman_buku.id_siswa')
            ->where('id_peminjaman_buku', $id)
            ->get();
            return Response()->json($detail_peminjaman_buku);
        }else {
            return Response()->json(['message' => 'Couldnt find the data']);
        }
    }
    //read data end

    //update data start
    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        [
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali'  => 'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $update=DB::table('peminjaman_buku')
        ->where('id_peminjaman_buku', '=', $id)
        ->update([
            'id_siswa' => $request->id_siswa,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali
        ]);

        $data=PeminjamanBukumodel::where('id_peminjaman_buku', '=', $id)->get();
        if($update){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success updating data!',
                'data' => $data  
            ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed updating data!'
            ]);
        }
    }
    //update data end

    //delete data start
    public function delete($id){
        $delete=DB::table('peminjaman_buku')
        ->where('id_peminjaman_buku', '=', $id)
        ->delete();

        if($delete){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes delete data!'
        ]);
        } else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed delete data!'
        ]);
        }

    }
    //delete data end
}