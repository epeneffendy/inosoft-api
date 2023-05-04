<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanMotorResponse extends \stdClass
{
    private $responseCode = "200";
    private $responseMessage = "Successful";
    private $responseReason = array(
        "english" => "Success",
        "indonesia" => "Sukses"
    );
    private $merk = "";
    private $mesin = "";
    private $tipeSuspensi = "";
    private $tipeTransmisi = "";
    private $status = "Available";
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


    public function getstatus(): string
    {
        return $this->status;
    }

    public function setstatus($status): void
    {
        $this->status = $status;
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
