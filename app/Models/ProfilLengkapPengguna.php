<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilLengkapPengguna extends Model
{
    protected $table = "profil_lengkap_penggunas";

    protected $fillable = [
        'user_id',
        'name_penerima',
        'alamat',
        'no_telp',
        'provinsi_id',
        'kota_id',
        'provinsi_nama',
        'kota_id',
        'kota_nama',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
