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
        'is_default',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set this address as default and unset others
     */
    public function setAsDefault()
    {
        // Unset all other default addresses for this user
        self::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);
        
        // Set this address as default
        $this->update(['is_default' => true]);
    }

    /**
     * Get default address for a user
     */
    public static function getDefaultForUser($userId)
    {
        return self::where('user_id', $userId)
                   ->where('is_default', true)
                   ->first();
    }

    /**
     * Scope for default addresses
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
