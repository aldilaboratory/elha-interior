<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = "transaksi_detail";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'nama_produk',
        'gambar_produk',
        'harga',
        'jumlah',
        'subtotal',
        "created_at",
        "updated_at",
    ];

    /**
     * Get the transaction that owns the detail.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    /**
     * Get the product that owns the detail.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
