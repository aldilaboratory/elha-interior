<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = "produk";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "nama",
        "deskripsi",
        "image",
        "harga",
        "berat",
        "stok",
        "kategori_id",
        "created_at",
        "updated_at",
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }
}
