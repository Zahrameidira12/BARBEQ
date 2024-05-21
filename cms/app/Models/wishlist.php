<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "wishlists";
    protected $fillable = [

        'pembeli_id',
        'kategori_id',
        'produk_id',

    ];
    public function kategori()
    {
        //Post ke Categories Relasi satu ke satu
        return $this->belongsTo(Kategori::class);

    }
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }
}
