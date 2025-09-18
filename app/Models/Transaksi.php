<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = "transaksi";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'nama_penerima',
        'alamat',
        'no_hp',
        'provinsi_id',
        'provinsi_nama',
        'kota_id',
        'kota_nama',
        'kurir',
        'paket',
        'paket_harga',
        'paket_estimasi',
        'ongkir',
        'total',
        'status',
        'payment_method',
        'resi',
        'snap_token',
        "created_at",
        "updated_at",
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transaction details for the transaction.
     */
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
