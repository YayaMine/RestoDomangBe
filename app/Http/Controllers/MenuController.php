<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();

        return response()->json([
            'status' => 'success',
            'data' => $menus,
        ]);
    }

    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $menu,
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori_menu' => 'required|in:makanan,minuman,paket',
            'harga_menu' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto_menu' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file gambar langsung ke folder public/storage
        if ($request->hasFile('foto_menu')) {
            $path = $request->file('foto_menu')->store('', 'public');
            $validated['foto_menu'] = $path; // Path relatif langsung
        }

        $menu = Menu::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $menu,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'nama_menu' => 'sometimes|string|max:255',
            'kategori_menu' => 'sometimes|in:makanan,minuman,paket',
            'harga_menu' => 'sometimes|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto_menu' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Hapus file lama dan simpan file baru jika ada
        if ($request->hasFile('foto_menu')) {
            if ($menu->foto_menu && Storage::exists('public/' . $menu->foto_menu)) {
                Storage::delete('public/' . $menu->foto_menu);
            }

            $path = $request->file('foto_menu')->store('', 'public');
            $validated['foto_menu'] = $path;
        }

        $menu->update($validated);

        return response()->json([
            'status' => 'success',
            'data' => $menu,
        ]);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
            ], 404);
        }

        // Periksa dan hapus file gambar jika ada
        if ($menu->foto_menu && Storage::exists('public/' . $menu->foto_menu)) {
            Storage::delete('public/' . $menu->foto_menu);
        }

        $menu->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Menu berhasil dihapus',
        ]);
    }
}