<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Usaha extends Model
{
    use HasUuids;

    protected $table = 'usaha';

    protected $fillable = [
        'nama_pemilik',
        'nama_usaha',
        'deskripsi_kegiatan',
        'kbli_kategori_kode',
        'kbli_kategori_nama',
        'kbli_golongan_pokok_kode',
        'kbli_golongan_pokok_nama',
        'kbli_golongan_kode',
        'kbli_golongan_nama',
        'kbli_subgolongan_kode',
        'kbli_subgolongan_nama',
        'kbli_kelompok_kode',
        'kbli_kelompok_nama',
        'provinsi_kode',
        'provinsi_nama',
        'kabkot_kode',
        'kabkot_nama',
        'kecamatan_kode',
        'kecamatan_nama',
        'desa_kode',
        'desa_nama',
        'sls_kode',
        'sls_nama',
        'sub_sls',
        'latitude',
        'longitude',
        'platform_digital',
        'kelas_usaha',
        'cakupan_pasar',
        'created_by',
        'updated_by',
        'is_active',
        'status',
    ];

    protected $appends = ['platforms'];

    protected $hidden = ['platform_digital'];

    protected function casts(): array
    {
        return [
            'platform_digital' => 'array',
            'latitude' => 'double',
            'longitude' => 'double',
            'is_active' => 'boolean',
        ];
    }

    public function getPlatformsAttribute(): array
    {
        return $this->platform_digital ?? [];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
