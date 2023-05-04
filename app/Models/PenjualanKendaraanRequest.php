<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanKendaraanRequest extends \stdClass
{
    private $type = '';
    private $kendaraanIds = '';
    private $tanggal = '';

    public function __construct($response)
    {
        $has = get_object_vars($this);
        foreach ($has as $name => $oldValue) {
            !array_key_exists($name, $response) ?: $this->{'set' . $name}($response[$name]);
        }
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
}
