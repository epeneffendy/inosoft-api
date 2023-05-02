<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Motor extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'motor';

    public function kendaraan()
    {
        return $this->embedsOne('Kendaraan');
    }
}
