<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiRetur extends Model
{
    use HasFactory;

    protected $table = 'transaksi_retur';

    protected $fillable = ['user_id', 'transaksi_penjualan_detail_id', 'tgl_transaksi', 'jml_barang', 'keterangan'];

    protected $casts = [
        'tgl_transaksi' => 'datetime',
    ];

    public function transaksiPenjualanDetail()
    {
        return $this->belongsTo(TransaksiPenjualanDetail::class, 'transaksi_penjualan_detail_id', 'id');
    }

    public function barang()
    {
        return $this->hasOneThrough(
            Barang::class, 
            TransaksiPenjualanDetail::class,
            'id', // Foreign key on TransaksiPenjualanDetail
            'id', // Foreign key on Barang
            'transaksi_penjualan_detail_id', // Local key on TransaksiRetur
            'barang_id' // Local key on TransaksiPenjualanDetail
        );
    }
    
    public function barangDetail()
    {
        return $this->hasOneThrough(
            BarangDetail::class, 
            Barang::class, 
            'id', 
            'barang_id', 
            'transaksi_penjualan_detail_id', 
            'id'
        );
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function pelanggan()
    {
        return $this->hasOneThrough(
            Pelanggan::class,
            TransaksiPenjualan::class,
            'id', // Foreign key on TransaksiPenjualan
            'id', // Foreign key on Pelanggan
            'transaksi_penjualan_detail_id', // Local key on TransaksiRetur
            'pelanggan_id' // Local key on TransaksiPenjualan
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
