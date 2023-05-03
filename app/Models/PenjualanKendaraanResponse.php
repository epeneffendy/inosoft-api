<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanKendaraanResponse extends \stdClass
{
    private $responseCode = "200";
    private $responseMessage = "Successful";
    private $responseReason = array(
        "english" => "Success",
        "indonesia" => "Sukses"
    );
    private $type = '';
    private $kendaraanIds = '';
    private $tanggal = '';
    private $detail = array(
        "merk" => '',
        "mesin" => '',
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

    public function gettype()
    {
        return $this->type;
    }

    public function settype($type): void
    {
        $this->type = $type;
    }

    public function getkendaraanIds()
    {
        return $this->kendaraanIds;
    }

    public function setkendaraanIds($kendaraanIds): void
    {
        $this->kendaraanIds = $kendaraanIds;
    }

    public function gettanggal()
    {
        return $this->tanggal;
    }

    public function settanggal($tanggal): void
    {
        $this->tanggal = $tanggal;
    }

    public function getdetail(): Collection
    {
        return collect($this->detail);
    }

    public function setdetail($detail): void
    {
        $this->detail= $detail;
    }

}
