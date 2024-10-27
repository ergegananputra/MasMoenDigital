<?php

namespace App\Http\Controllers;

use App\Models\DataPeserta;
use Illuminate\Http\Request;
use App\Helpers\ResponseJSON;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\DataPersertaRequest;
use Illuminate\Validation\ValidationException;

class DataPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = DataPeserta::orderByDesc('tanggalPendataan')->get();
            return ResponseJSON::success($data);
        } catch (\Throwable $th) {
            return ResponseJSON::error("Data peserta tidak ditemukan");
        }
        
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataPersertaRequest $request)
    {
        try {
            $request = $request->validated();

            $file = $request['image'];
            
            // Store Image
            $filename = time() . '.' . $file->getClientOriginalName();
            $filepath = $file->storeAs('uploads', $filename, 'public');
    

            $request['imageUrl'] = $filepath;

            $data = DataPeserta::create($request);
            return ResponseJSON::success($data, "Data peserta berhasil ditambahkan");
        }catch (\Throwable $th) {
            Log::error($th);
            return ResponseJSON::error("Data peserta gagal ditambahkan");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $data = DataPeserta::find($id);
            return ResponseJSON::success($data);
        } catch (\Throwable $th) {
            return ResponseJSON::error("Data peserta tidak ditemukan");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $dataPeserta = DataPeserta::find($id);
            $dataPeserta->delete();
            return ResponseJSON::success(
                data: $dataPeserta, 
                message: "Data peserta berhasil dihapus"
                );
        } catch (\Throwable $th) {
            return ResponseJSON::error("Data peserta gagal dihapus");
        }
    }
}
