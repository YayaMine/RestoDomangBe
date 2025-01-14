<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';

    // Kolom yang dapat diisi
    protected $fillable = [
        'user_id',
        'nomor_telepon',
        'tanggal_reservasi',
        'jam_reservasi',
        'jumlah_orang',
        'meja_id',
        'status', // Kolom status ditambahkan
        'snap_token', // Kolom snap_token ditambahkan jika menggunakan Midtrans
    ];

    /**
     * Relasi ke tabel Meja.
     */
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }

    /**
     * Relasi ke tabel User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope untuk mencari reservasi berdasarkan status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk mencari reservasi berdasarkan tanggal.
     */
    public function scopeByDate($query, $date)
    {
        return $query->where('tanggal_reservasi', $date);
    }
}
