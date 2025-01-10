<?php

namespace App\Models;

use App\Models\Jenis;
use App\Models\Satuan;
use App\Models\BarangDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;
    
    protected $table = 'barang';

    protected $fillable = ['nama', 'foto', 'stok', 'status'];

    public function detail()
    {
        return $this->hasOne(BarangDetail::class, 'barang_id');
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
