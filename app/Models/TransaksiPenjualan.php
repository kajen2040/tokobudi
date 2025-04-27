<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_penjualan';

    protected $fillable = ['user_id', 'barang_id', 'diskon_id', 'pelanggan_id', 'tgl_transaksi', 'jml_barang', 'total', 'keterangan'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
    
    public function barangDetail()
    {
        return $this->hasOneThrough(BarangDetail::class, Barang::class, 'id', 'barang_id', 'barang_id', 'id');
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function diskon()
    {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public static function calculateTotalSales()
    {
        return self::sum('jml_barang');
    }
}
