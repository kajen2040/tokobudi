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

    protected $fillable = ['user_id', 'barang_id', 'suplier_id', 'tgl_transaksi', 'jml_barang', 'keterangan'];

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
}
