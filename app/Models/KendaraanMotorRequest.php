<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanMotorRequest extends  \stdClass
{
    private $mesin = "";
    private $tipeSuspensi = "";
    private $tipeTransmisi = "";
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

    public function getmesin()
    {
        return $this->mesin;
    }

    public function setmesin($mesin): void
    {
        $this->mesin = $mesin;
    }

    public function gettipeSuspensi()
    {
        return $this->tipeSuspensi;
    }

    public function settipeSuspensi($tipeSuspensi): void
    {
        $this->tipeSuspensi = $tipeSuspensi;
    }

    public function gettipeTransmisi()
    {
        return $this->tipeTransmisi;
    }

    public function settipeTransmisi($tipeTransmisi): void
    {
        $this->tipeTransmisi = $tipeTransmisi;
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
