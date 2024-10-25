<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('namaLengkap');
            $table->string('nomorHandphone');
            $table->integer('gender');
            $table->dateTime('tanggalPendataan');
            $table->string('alamat');
            $table->string('imageUrl');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pesertas');
    }
};
