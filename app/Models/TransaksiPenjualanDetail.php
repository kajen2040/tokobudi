<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'transaksi_penjualan_detail';

    protected $fillable = ['transaksi_penjualan_id', 'barang_id', 'diskon_id', 'jml_barang', 'harga_satuan', 'subtotal'];

    public function transaksiPenjualan()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'transaksi_penjualan_id', 'id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
    
    public function barangDetail()
    {
        return $this->hasOneThrough(BarangDetail::class, Barang::class, 'id', 'barang_id', 'barang_id', 'id');
    }

    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }
} 