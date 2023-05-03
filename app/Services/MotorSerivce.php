<?php
namespace App\Services;

use App\Models\Kendaraan;
use App\Models\KendaraanMotorRequest;
use App\Models\KendaraanMotorResponse;
use App\Models\Motor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MotorSerivce
{
    public function storeMotor(KendaraanMotorRequest $data, KendaraanMotorResponse $result, $request, $slug, $motor = null)
    {
        try {
            $kendaraan = new Kendaraan();
            if ($slug == 'update') {
                $kendaraan = Kendaraan::where('_id', '=', $motor->kendaraan->_id)->first();
            }
            $kendaraan->tahun_keluaran = $request['kendaraan']['tahunKeluaran'];
            $kendaraan->warna = $request['kendaraan']['warna'];
            $kendaraan->harga = $request['kendaraan']['harga'];
            if (!$kendaraan->save()) {
                $result->setresponseMessage("Failed");
                $result->setresponseReason(array(
                    "english" => "Vehicle Data Failed to Add",
                    "indonesia" => "Data Kendaraan Gagal Ditambahkan"
                ));
                return $result;
            }
            if ($slug == 'insert') {
                $motor = new Motor();
            }
            $motor->kendaraan_id = $kendaraan->_id;
            $motor->merk = $data->getmerk();
            $motor->mesin = $data->getmesin();
            $motor->tipe_suspensi = $data->gettipeSuspensi();
            $motor->tipe_transmisi = $data->gettipeTransmisi();
            $motor->status = $result->getstatus();
            if (!$motor->save()) {
                $result->setresponseMessage("Failed");
                $result->setresponseReason(array(
                    "english" => "Vehicle Data Failed to Add",
                    "indonesia" => "Data Kendaraan Gagal Ditambahkan"
                ));
                return $result;
            }

            $result->setresponseReason(array(
                "english" => "Data Added Successfully",
                "indonesia" => "Data Berhasil Ditambahkan"
            ));
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }

    }

    public function fetchStok()
    {
        $stoks = [];
        $datas = $this->getAllAvailable();
        $mesin = '';
        $jumlah = 1;
        foreach ($datas as $item) {
            if ($mesin == $item->merk) {
                $jumlah++;
            } else {
                $jumlah = 1;
            }

            $stoks[$item->merk]['merk'] = $item->merk;
            $stoks[$item->merk]['stok'] = $jumlah;
            $stoks[$item->merk]['details'][$item->_id]['mesin'] = $item->mesin;
            $stoks[$item->merk]['details'][$item->_id]['tipe_suspensi'] = $item->tipe_suspensi;
            $stoks[$item->merk]['details'][$item->_id]['tipe_transmisi'] = $item->tipe_transmisi;
            $stoks[$item->merk]['details'][$item->_id]['kendaraan']['tahun_keluaran'] = $item->kendaraan->tahun_keluaran;
            $stoks[$item->merk]['details'][$item->_id]['kendaraan']['warna'] = $item->kendaraan->warna;
            $stoks[$item->merk]['details'][$item->_id]['kendaraan']['harga'] = $item->kendaraan->harga;
            $mesin = $item->merk;
        }

        return $stoks;
    }

    public function getAll()
    {
        $data = Motor::all();
        return $data;
    }

    public function getAllAvailable()
    {
        $data = Motor::where('status', '=', 'Available')->all();
        return $data;
    }

    public function findById($id)
    {
        $data = Motor::where('_id', '=', $id)->first();
        return $data;
    }

    public function delete($id)
    {
        $data = $this->findById($id);
        $data->delete();
    }

}