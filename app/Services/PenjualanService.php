<?php
namespace App\Services;

use App\Models\Mobil;
use App\Models\Penjualan;
use App\Models\PenjualanKendaraanRequest;
use App\Models\PenjualanKendaraanResponse;

class PenjualanService
{
    public function storePenjualan(PenjualanKendaraanRequest $data, PenjualanKendaraanResponse $result, MobilSerivce $mobilSerivce, MotorSerivce $motorSerivce)
    {
        if ($data->gettype() == 'mobil') {
            $penjualan = new Penjualan();
            $penjualan->kendaraan_type = 'App\Models\Mobil';
            $penjualan->kendaraan_ids = $data->getkendaraanIds();
            $penjualan->tanggal = $data->gettanggal();

            if (!$penjualan->save()) {
                $result->setresponseMessage("Failed");
                $result->setresponseReason(array(
                    "english" => "Sales Failed to Process",
                    "indonesia" => "Penjualan Gagal di Proses"
                ));
                return $result;
            }

            $mobil = $mobilSerivce->findById($data->getkendaraanIds());
            if ($mobil->status == 'Available') {
                $mobil->status = 'Sold';
                if (!$mobil->save()) {
                    $result->setresponseMessage("Failed");
                    $result->setresponseReason(array(
                        "english" => "Failed Car Satus Update",
                        "indonesia" => "Update Status Mobil Gagal"
                    ));
                    return $result;
                }

                $result->setresponseReason(array(
                    "english" => "Successfuly Sales Process",
                    "indonesia" => "Proses Penjualan Berhasil"
                ));
                $result->setdetail(array(
                    "merk" => $mobil->merk,
                    "mesin" => $mobil->mesin,
                    "kapasitas_penumpang" => $mobil->kapasitas_penumpang,
                    "tipe" => $mobil->tipe,
                    "kendaraan" => array(
                        "tahun_keluaran" => $mobil->kendaraan->tahun_keluaran,
                        "warna" => $mobil->kendaraan->warna,
                        "harga" => $mobil->kendaraan->harga,
                    )
                ));
            } else {
                $result->setresponseMessage("Failed");
                $result->setresponseReason(array(
                    "english" => "The Car has been sold",
                    "indonesia" => "Mobil telah terjual"
                ));
                $result->setdetail(array(
                    "merk" => $mobil->merk,
                    "mesin" => $mobil->mesin,
                    "kapasitas_penumpang" => $mobil->kapasitas_penumpang,
                    "tipe" => $mobil->tipe,
                    "kendaraan" => array(
                        "tahun_keluaran" => $mobil->kendaraan->tahun_keluaran,
                        "warna" => $mobil->kendaraan->warna,
                        "harga" => $mobil->kendaraan->harga,
                    )
                ));
            }

            return $result;
        } else {
            $penjualan = new Penjualan();
            $penjualan->kendaraan_type = 'App\Models\Motor';
            $penjualan->kendaraan_ids = $data->getkendaraanIds();
            $penjualan->tanggal = $data->gettanggal();

            if (!$penjualan->save()) {
                $result->setresponseMessage("Failed");
                $result->setresponseReason(array(
                    "english" => "Sales Failed to Process",
                    "indonesia" => "Penjualan Gagal di Proses"
                ));
                return $result;
            }

            $motor = $motorSerivce->findById($data->getkendaraanIds());
            if ($motor->status == 'Available') {
                $motor->status = 'Sold';
                if (!$motor->save()) {
                    $result->setresponseMessage("Failed");
                    $result->setresponseReason(array(
                        "english" => "Failed Motorcycle Satus Update",
                        "indonesia" => "Update Status Motor Gagal"
                    ));
                    return $result;
                }

                $result->setresponseReason(array(
                    "english" => "Successfuly Sales Process",
                    "indonesia" => "Proses Penjualan Berhasil"
                ));
                $result->setdetail(array(
                    "merk" => $motor->merk,
                    "mesin" => $motor->mesin,
                    "tipe_suspensi" => $motor->tipe_suspensi,
                    "tipe_transmisi" => $motor->tipe_transmisi,
                    "kendaraan" => array(
                        "tahun_keluaran" => $motor->kendaraan->tahun_keluaran,
                        "warna" => $motor->kendaraan->warna,
                        "harga" => $motor->kendaraan->harga,
                    )
                ));
            } else {
                $result->setresponseMessage("Failed");
                $result->setresponseReason(array(
                    "english" => "The Motorcycle has been sold",
                    "indonesia" => "Motor telah terjual"
                ));
                $result->setdetail(array(
                    "merk" => $motor->merk,
                    "mesin" => $motor->mesin,
                    "tipe_suspensi" => $motor->tipe_suspensi,
                    "tipe_transmisi" => $motor->tipe_transmisi,
                    "kendaraan" => array(
                        "tahun_keluaran" => $motor->kendaraan->tahun_keluaran,
                        "warna" => $motor->kendaraan->warna,
                        "harga" => $motor->kendaraan->harga,
                    )
                ));
            }

            return $result;
        }
    }

    public function fetchLaporan($type, $value)
    {
//        $datas = Penjualan::where
    }
}