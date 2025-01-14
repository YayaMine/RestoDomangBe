<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class ReservasiController extends Controller
{
    public function __construct()
    {
        // Setup konfigurasi Midtrans menggunakan config/midtrans.php
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Menampilkan semua reservasi.
     */
    public function index()
    {
        $reservasi = Reservasi::with('user', 'meja')->get();

        return response()->json([
            'status' => 'success',
            'data' => $reservasi,
        ]);
    }

    /**
     * Membuat reservasi baru dengan status default 'paid'.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi' => 'required|date_format:H:i|after_or_equal:12:00|before_or_equal:22:00',
            'jumlah_orang' => 'required|integer|min:1',
            'meja_id' => 'required|exists:meja,id',
        ]);

        // Ambil detail meja dan harga
        $meja = Meja::findOrFail($validated['meja_id']);
        $order_id = 'RESERVASI-' . uniqid(); // ID unik untuk transaksi

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $meja->harga_meja, // Harga meja
            ],
            'customer_details' => [
                'first_name' => $request->user()->name ?? 'Guest',
                'email' => $request->user()->email ?? 'guest@example.com',
                'phone' => $validated['nomor_telepon'],
            ],
        ];

        // Generate Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Simpan data reservasi dengan status 'paid' secara default
        $reservasi = Reservasi::create([
            'user_id' => $validated['user_id'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'tanggal_reservasi' => $validated['tanggal_reservasi'],
            'jam_reservasi' => $validated['jam_reservasi'],
            'jumlah_orang' => $validated['jumlah_orang'],
            'meja_id' => $validated['meja_id'],
            'status' => 'paid', // Status default diatur menjadi 'paid'
            'snap_token' => $snapToken, // Simpan Snap Token untuk referensi
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil dibuat.',
            'snap_token' => $snapToken, // Kirimkan Snap Token ke frontend
            'data' => $reservasi,
        ]);
    }

    /**
     * Notifikasi pembayaran dari Midtrans.
     */
    public function paymentNotification(Request $request)
    {
        // Ambil notifikasi dari Midtrans
        $payload = $request->getContent();
        $notification = json_decode($payload, true);

        // Konfigurasi Midtrans
        $midtrans = new \Midtrans\Notification();

        $transaction_status = $midtrans->transaction_status;
        $order_id = $midtrans->order_id;

        // Ambil ID reservasi dari order_id
        $reservasi_id = explode('-', $order_id)[1];

        // Cari reservasi berdasarkan ID
        $reservasi = Reservasi::find($reservasi_id);

        if (!$reservasi) {
            return response()->json(['message' => 'Reservasi tidak ditemukan'], 404);
        }

        // Perbarui status berdasarkan status transaksi
        switch ($transaction_status) {
            case 'capture':
            case 'settlement': // Pembayaran berhasil
                $reservasi->status = 'paid';
                break;
            case 'pending': // Pembayaran sedang menunggu
                $reservasi->status = 'pending';
                break;
            case 'deny': // Pembayaran ditolak
            case 'expire': // Pembayaran kadaluarsa
            case 'cancel': // Pembayaran dibatalkan
                $reservasi->status = 'failed';
                break;
        }

        // Simpan pembaruan ke database
        $reservasi->save();

        return response()->json([
            'message' => 'Notifikasi pembayaran diproses',
            'status' => $reservasi->status,
        ]);
    }

    /**
     * Menampilkan meja yang tersedia berdasarkan jumlah orang.
     */
    public function availableTables(Request $request)
    {
        $request->validate([
            'jumlah_orang' => 'required|integer|min:1',
        ]);

        $jumlah_orang = $request->input('jumlah_orang');

        // Ambil meja yang memenuhi jumlah orang
        $availableTables = Meja::select('id', 'nomor_meja', 'jumlah_orang')
            ->where('jumlah_orang', '>=', $jumlah_orang)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $availableTables,
        ]);
    }
}