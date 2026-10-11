<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenugasanGuru extends Model
{
    protected $table = 'penugasan_guru';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(
            MataPelajaran::class,
            'mata_pelajaran_id'
        );
    }
}
