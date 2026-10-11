
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan_guru', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guru_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->restrictOnDelete();

            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajaran')
                ->restrictOnDelete();

            $table->timestamps();

            $table->unique(
                ['guru_id', 'kelas_id', 'mata_pelajaran_id'],
                'penugasan_guru_kelas_mapel_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan_guru');
    }
};
