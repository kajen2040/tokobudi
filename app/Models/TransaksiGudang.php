<?php

namespace App\Models;

use App\Models\Jenis;
use App\Models\Satuan;
use App\Models\BarangDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiGudang extends Model
{
    use HasFactory;

    protected $table = 'transaksi_gudang';

    protected $fillable = [
        'user_id', 
        'barang_id', 
        'suplier_id', 
        'tgl_transaksi', 
        'jml_barang', 
        'harga_beli',
        'keterangan'
    ];

    protected $casts = [
        'tgl_transaksi' => 'date',
        'harga_beli' => 'decimal:2',
        'jml_barang' => 'integer'
    ];

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

    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'suplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
