<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class Penjualan extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'penjualan';

    public function kendaraanMorp()
    {
        return $this->morphTo();
    }

    public function kendaraan(){
        return $this->morphTo(__FUNCTION__, 'kendaraan_type', 'kendaraan_ids');
    }

}
