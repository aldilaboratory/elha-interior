<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = "user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "username",
        "email",
        "phone",
        "password",
        "group_id",
        "provinsi_id",
        "kab_kot_id",
        "kecamatan_id",
        "desa_id",
        "alamat",
        "created_at",
        "updated_at",
    ];

    public function profileLengkaps() : HasMany {
        return $this->hasMany(ProfilLengkapPengguna::class);
    }
}
