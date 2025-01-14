<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meja = Meja::all(); // Ambil semua data meja
        return response()->json($meja);
    }

    /**
     * Show the form for creating a new resource.
     * This function is renamed from "store" to "create".
     */
    public function create(Request $request)
    {
        $request->validate([
            'jumlah_orang' => 'required|integer|min:1',
            'nomor_meja' => 'required|string|unique:meja,nomor_meja',
            'letak_meja' => 'required|string',
            'harga_meja' => 'required|numeric|min:0',
        ]);

        $meja = Meja::create($request->all());

        return response()->json([
            'message' => 'Meja berhasil ditambahkan!',
            'data' => $meja,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan!'], 404);
        }

        return response()->json($meja);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan!'], 404);
        }

        $request->validate([
            'jumlah_orang' => 'sometimes|integer|min:1',
            'nomor_meja' => 'sometimes|string|unique:meja,nomor_meja,' . $id,
            'letak_meja' => 'sometimes|string',
            'harga_meja' => 'sometimes|numeric|min:0',
        ]);

        $meja->update($request->all());

        return response()->json([
            'message' => 'Meja berhasil diperbarui!',
            'data' => $meja,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan!'], 404);
        }

        $meja->delete();

        return response()->json(['message' => 'Meja berhasil dihapus!']);
    }
}