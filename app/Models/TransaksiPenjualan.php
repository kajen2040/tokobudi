<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_penjualan';

    protected $fillable = ['user_id', 'pelanggan_id', 'tgl_transaksi', 'total', 'keterangan'];

    public function details()
    {
        return $this->hasMany(TransaksiPenjualanDetail::class, 'transaksi_penjualan_id', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function calculateTotalSales()
    {
        return self::sum('total');
    }
}
