<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap menu
            $table->string('nama_menu'); // Nama menu
            $table->enum('kategori_menu', ['minuman', 'makanan', 'paket']); // Kategori menu (minuman, makanan, paket)
            $table->decimal('harga_menu', 10, 2); // Harga menu
            $table->text('deskripsi')->nullable(); // Deskripsi menu, nullable
            $table->string('foto_menu')->nullable(); // Path foto menu, nullable
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}