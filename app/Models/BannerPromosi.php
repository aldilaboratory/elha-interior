<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerPromosi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = "banner_promosi";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "nama",
        "deskripsi",
        "image",
        "created_at",
        "updated_at",
    ];
}
