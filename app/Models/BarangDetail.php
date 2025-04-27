<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\Jenis;
use App\Models\Satuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangDetail extends Model
{
    use HasFactory;

    protected $table = 'barang_detail';

    protected $fillable = ['barang_id', 'jenis_id', 'satuan_id', 'harga_beli', 'harga_jual', 'barcode'];

    protected $casts = [
        'harga_beli' => 'integer',
        'harga_jual' => 'integer',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
