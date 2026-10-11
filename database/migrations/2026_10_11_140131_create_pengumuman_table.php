
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pembuat_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('judul', 200);
            $table->text('isi');

            $table->string('cakupan', 20)->default('sekolah');

            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->nullOnDelete();

            $table->string('status', 20)->default('draft');
            $table->timestamp('tanggal_publikasi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
