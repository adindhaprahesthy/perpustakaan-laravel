<?php

namespace App\Http\Controllers;
use App\Models\DetailPeminjamanBukumodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailPeminjamanBukucontroller extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_peminjaman_buku'=>'required',
            'id_buku'=>'required',
            'qty'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = DetailPeminjamanBukumodel::create([
            'id_peminjaman_buku' =>$request->id_peminjaman_buku,
            'id_buku'            =>$request->id_buku,
            'qty'                =>$request->qty
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }

    public function show(){
        $data = DB::table('detail_peminjaman_buku')
        ->join('peminjaman_buku', 'detail_peminjaman_buku.id_peminjaman_buku', '=', 'peminjaman_buku.id_peminjaman_buku')
        ->join('buku', 'detail_peminjaman_buku.id_buku', '=', 'buku.id_buku') 
        ->select('detail_peminjaman_buku.id_detail_peminjaman_buku', 'peminjaman_buku.id_peminjaman_buku', 'peminjaman_buku.tanggal_pinjam', 'buku.nama_buku', 'detail_peminjaman_buku.qty')
        ->get();
        return Response()->json($data);
    }

    public function detail($id){
        if(DetailPeminjamanBukumodel::where('id_detail_peminjaman_buku', $id)->exists()){
            $data_detail_peminjaman_buku = DB::table('detail_peminjaman_buku')
            ->join('peminjaman_buku', 'detail_peminjaman_buku.id_peminjaman_buku', '=', 'peminjaman_buku.id_peminjaman_buku')
            ->join('buku', 'detail_peminjaman_buku.id_buku', '=', 'buku.id_buku') 
            ->select('detail_peminjaman_buku.id_detail_peminjaman_buku', 'peminjaman_buku.id_peminjaman_buku', 'peminjaman_buku.tanggal_pinjam', 'buku.nama_buku', 'detail_peminjaman_buku.qty')
            ->where('detail_peminjaman_buku.id_detail_peminjaman_buku', '=', $id)
            ->get();
            return Response()->json($data_detail_peminjaman_buku);
        }else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }

    public function update($id, Request $request) {         
        $validator=Validator::make($request->all(),         
        [   
            'id_peminjaman_buku'=>'required',
            'id_buku'=>'required',
            'qty'=>'required'       
        ]); 

        if($validator->fails()) {             
            return Response()->json($validator->errors());         
        } 

        $ubah = DetailPeminjamanBukumodel::where('id_detail_peminjaman_buku', $id)->update([             
            'id_peminjaman_buku' =>$request->id_peminjaman_buku,
            'id_buku'            =>$request->id_buku,
            'qty'                =>$request->qty
        ]); 

        if($ubah) {             
            return Response()->json(['status' => 1]);         
        }         
        else {             
            return Response()->json(['status' => 0]);         
        }     
    }
    
    public function destroy($id)
    {
        $hapus = DetailPeminjamanBukumodel::where('id_detail_peminjaman_buku', $id)->delete();

        if($hapus) {
            return Response()->json(['status' => 1]);
        }

        else {
            return Response()->json(['status' => 0]);
        }
    }
    
}