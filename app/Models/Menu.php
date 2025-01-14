<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_menu',
        'kategori_menu',
        'harga_menu',
        'deskripsi',
        'foto_menu', // Pastikan ini ada
    ];

    /**
     * Accessor to get the full URL of the menu's photo.
     *
     * @return string|null
     */
    public function getFotoMenuUrlAttribute()
    {
        if ($this->foto_menu) {
            return url('storage/' . $this->foto_menu);
        }
        return null;
    }
}