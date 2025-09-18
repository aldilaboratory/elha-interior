<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterPromosi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = "footer_promosi";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "nama",
        "deskripsi",
        "image",
        "produk_id",
        "created_at",
        "updated_at",
    ];
}
