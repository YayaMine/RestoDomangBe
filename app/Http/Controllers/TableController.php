<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    // Method untuk menambah meja
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string',
            'kapasitas' => 'required|integer',
            'status' => 'required|string',
        ]);

        // Membuat meja baru
        $meja = Table::create($request->all());

        return response()->json($meja, 201); // Mengembalikan data meja yang baru dibuat
    }

    // Method untuk menampilkan daftar meja
    public function index()
    {
        // Mengambil semua data meja
        $meja = Table::all();

        return response()->json($meja); // Mengembalikan data meja
    }

    // Method untuk menampilkan meja berdasarkan ID
    public function show($id)
    {
        // Mencari meja berdasarkan ID
        $meja = Table::find($id);

        // Jika meja tidak ditemukan
        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan'], 404);
        }

        return response()->json($meja); // Mengembalikan data meja berdasarkan ID
    }

    // Method untuk memperbarui meja
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_meja' => 'required|string',
            'kapasitas' => 'required|integer',
            'status' => 'required|string',
        ]);

        // Mencari meja berdasarkan ID
        $meja = Table::find($id);

        // Jika meja tidak ditemukan
        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan'], 404);
        }

        // Mengupdate data meja
        $meja->update($request->all());

        return response()->json($meja); // Mengembalikan data meja yang telah diperbarui
    }

    // Method untuk menghapus meja
    public function destroy($id)
    {
        // Mencari meja berdasarkan ID
        $meja = Table::find($id);

        // Jika meja tidak ditemukan
        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan'], 404);
        }

        // Menghapus meja
        $meja->delete();

        return response()->json(['message' => 'Meja berhasil dihapus']); // Mengembalikan pesan sukses
    }
}
