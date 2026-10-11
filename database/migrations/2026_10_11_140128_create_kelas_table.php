
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jurusan_id')
                ->constrained('jurusan')
                ->restrictOnDelete();

            $table->string('nama_kelas', 50);
            $table->unsignedTinyInteger('tingkat');
            $table->string('tahun_ajaran', 9);

            $table->foreignId('wali_kelas_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(
                ['nama_kelas', 'tahun_ajaran'],
                'kelas_nama_tahun_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
