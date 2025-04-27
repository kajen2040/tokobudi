<?php

namespace App\Models;

use App\Models\Jenis;
use App\Models\Satuan;
use App\Models\BarangDetail;
use App\Models\TransaksiGudang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;
    
    protected $table = 'barang';

    protected $fillable = ['nama', 'foto', 'stok', 'status'];

    protected $with = ['detail'];

    public function detail()
    {
        return $this->hasOne(BarangDetail::class);
    }

    public function jenis()
    {
        return $this->hasOneThrough(Jenis::class, BarangDetail::class, 'barang_id', 'id', 'id', 'jenis_id');
    }

    public function satuan()
    {
        return $this->hasOneThrough(Satuan::class, BarangDetail::class, 'barang_id', 'id', 'id', 'satuan_id');
    }

    public function getLastPurchasePriceAttribute()
    {
        $lastPurchase = TransaksiGudang::where('barang_id', $this->id)
            ->orderBy('tgl_transaksi', 'desc')
            ->first();
            
        return $lastPurchase ? $lastPurchase->harga_beli : 0;
    }
}
