<?php
namespace App\Services;

use App\Models\Motor;
use App\Models\Penjualan;
use App\Models\PenjualanKendaraanRequest;
use App\Models\PenjualanKendaraanResponse;
use Carbon\Carbon;

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

    public function fetchLaporan($col, $value)
    {
        if ($col == 'kendaraan_type') {
            $model = 'App\Models\Mobil';
            if ($value == 'motor') {
                $model = 'App\Models\Motor';
            }
            $value = $model;
        }

        $datas = Penjualan::where($col, '=', $value)->get();

        $report = [];
        foreach ($datas as $item) {
            $type = 'Motor';
            if ($item->kendaraan_type == 'App\Models\Mobil') {
                $type = 'Mobil';
            }
            $report[$item->_id]['_ids'] = $item->_id;
            $report[$item->_id]['type'] = $type;
            $report[$item->_id]['tanggal'] = Carbon::parse($item->tanggal)->format('d-m-Y');
            $report[$item->_id]['detail'][$item->kendaraan->_id]['id'] = $item->kendaraan->_id;
            $report[$item->_id]['detail'][$item->kendaraan->_id]['merk'] = $item->kendaraan->merk;
            $report[$item->_id]['detail'][$item->kendaraan->_id]['mesin'] = $item->kendaraan->mesin;
            $report[$item->_id]['detail'][$item->kendaraan->_id]['status'] = $item->kendaraan->status;
            $report[$item->_id]['detail'][$item->kendaraan->_id]['kendaraan']['tahun_keluaran'] = $item->kendaraan->kendaraan->tahun_keluaran;
            $report[$item->_id]['detail'][$item->kendaraan->_id]['kendaraan']['warna'] = $item->kendaraan->kendaraan->warna;
            $report[$item->_id]['detail'][$item->kendaraan->_id]['kendaraan']['harga'] = $item->kendaraan->kendaraan->harga;
        }

        return $report;
    }
}