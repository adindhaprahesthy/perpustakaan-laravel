<?php

namespace App\Http\Controllers;
use App\Models\Bukumodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Bukucontroller extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_buku'=>'required',
            'pengarang'=>'required',
            'deskripsi'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = bukuModel::create([
            'nama_buku'    =>$request->nama_buku,
            'pengarang'    =>$request->pengarang,
            'deskripsi'    =>$request->deskripsi
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }

    public function UploadCoverBuku(Request $request, $id)
    {

    $validator=Validator::make($request->all(),
    [
    'cover_buku' => 'required|file|mimes:jpeg,png,jpg|max:2048',
    ]
    );
    
    if($validator->fails()) {
        return Response()->json($validator->errors());
    }

    //define nama file yang akan di upload
    $imageName = time().'.'.$request->cover_buku->extension();

    //proses upload
    $request->cover_buku->move(public_path('images'), $imageName);

    $update = Bukumodel::where('id_buku', $id)->update([
            'image' => $imageName
            ]);
    
    $data = Bukumodel::where('id_buku', '=', $id) -> get();
    if($update)
    {
        return Response()->json([
            'status' => 1,
            'message' => 'success upload cover buku !'
    ]);

    }
    else
    {
        return Response()->json([
            'status' => 0,
            'message' => 'failed upload cover buku !'
    ]);
    }
    }

    public function show()
    {
        return Bukumodel::all();
    }

    public function detail($id)
    {
        if(Bukumodel::where('id_buku', $id)->exists()){
            $data_buku= Bukumodel::select('buku.id_buku', 'nama_buku', 'pengarang', 'deskripsi')->where('id_buku', '=', $id)->get();
            return Response()->json($data_buku);
        }
        else{
            return Response()->json(['message' => 'Tidak ditemukan']);
        }
    }

    public function update($id, Request $request) {         
        $validator=Validator::make($request->all(),         
        [   
            'nama_buku'=>'required',
            'pengarang'=>'required',
            'deskripsi'=>'required'       
        ]); 

        if($validator->fails()) {             
            return Response()->json($validator->errors());         
        } 

        $ubah = Bukumodel::where('id_buku', $id)->update([             
            'nama_buku' =>$request->nama_buku,
            'pengarang' =>$request->pengarang,
            'deskripsi' =>$request->deskripsi
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
        $hapus = Bukumodel::where('id_buku', $id)->delete();

        if($hapus) {
            return Response()->json(['status' => 1]);
        }

        else {
            return Response()->json(['status' => 0]);
        }
    }
}
