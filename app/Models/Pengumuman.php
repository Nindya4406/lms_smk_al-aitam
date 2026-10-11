<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'pembuat_id',
        'judul',
        'isi',
        'cakupan',
        'kelas_id',
        'status',
        'tanggal_publikasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_publikasi' => 'datetime',
        ];
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
