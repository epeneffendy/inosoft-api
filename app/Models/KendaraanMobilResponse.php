<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanMobilResponse extends \stdClass
{
    private $responseCode = "200";
    private $responseMessage = "Successful";
    private $responseReason = array(
        "english" => "Success",
        "indonesia" => "Sukses"
    );
    private $mesin = "";
    private $kapasitasPenumpang = "";
    private $tipe = "";
    private $kendaraan = array(
        "tahun_kendaraan"=>'',
        "warna"=>'',
        "harga"=>"0.00",
    );

    public function __construct($response = null)
    {
        if ($response !== null) {
            $has = get_object_vars($this);
            foreach ($has as $name => $oldValue) {
                !array_key_exists($name, $response) ?: $this->{'set' . $name}($response[$name]);
            }
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

    public function getresponseMessage(): string
    {
        return $this->responseMessage;
    }

    public function setresponseMessage($responseMessage): void
    {
        $this->responseMessage = $responseMessage;
    }

    public function getresponseCode(): string
    {
        return $this->responseCode;
    }

    public function setresponseCode($responseCode): void
    {
        $this->responseCode = $responseCode;
    }

    public function getresponseReason(): Collection
    {
        return collect($this->responseReason);
    }

    public function setresponseReason($responseReason): void
    {
        $this->responseReason = $responseReason;
    }
}
