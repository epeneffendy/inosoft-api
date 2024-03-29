<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanMobilRequest extends  \stdClass
{
    private $merk = "";
    private $mesin = "";
    private $kapasitasPenumpang = "";
    private $tipe = "";
    private $kendaraan = array(
        "tahun_kendaraan"=>'',
        "warna"=>'',
        "harga"=>"0.00",
    );

    public function __construct($response)
    {
        $has = get_object_vars($this);
        foreach ($has as $name => $oldValue) {
            !array_key_exists($name, $response) ?: $this->{'set' . $name}($response[$name]);
        }
    }

    public function toArray()
    {
        $has = get_object_vars($this);
        $response = array();
        foreach ($has as $name => $value) {
            $response[$name] = $value;
        }
        return $response;
    }

    public function getmerk()
    {
        return $this->merk;
    }

    public function setmerk($merk): void
    {
        $this->merk = $merk;
    }

    public function getmesin()
    {
        return $this->mesin;
    }

    public function setmesin($mesin): void
    {
        $this->mesin = $mesin;
    }

    public function getkapasitasPenumpang()
    {
        return $this->kapasitasPenumpang;
    }

    public function setkapasitasPenumpang($kapasitasPenumpang): void
    {
        $this->kapasitasPenumpang = $kapasitasPenumpang;
    }

    public function gettipe()
    {
        return $this->tipe;
    }

    public function settipe($tipe): void
    {
        $this->tipe = $tipe;
    }

    public function getkendaraan(): Collection
    {
        return collect($this->kendaraan);
    }

    public function setkendaraan(array $kendaraan): void
    {
        $this->kendaraan = $kendaraan;
    }
}
