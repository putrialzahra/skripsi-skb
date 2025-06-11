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
        Schema::create('calon_peserta_didiks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('kebangsaan')->default('WNI');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('email')->unique();
            $table->enum('paket', ['A', 'B', 'C']); // Paket A/B/C
            $table->string('nama_lembaga');
            $table->text('alamat_lembaga');
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('no_hp_ortu');
            $table->string('kk')->nullable(); // path file
            $table->string('akta')->nullable(); // path file
            $table->string('ijazah')->nullable(); // path file
            $table->string('foto')->nullable(); // path file
            $table->boolean('pernyataan')->default(false);
            $table->enum('status', ['pending', 'terima', 'tidak_terima'])->default('pending');
            $table->integer('user_id')->nullable();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_peserta_didiks');
    }
};
