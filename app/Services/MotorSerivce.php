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
                $result->setrespinseReason(array(
                    "english" => "Vehicle Data Failed to Add",
                    "indonesia" => "Data Kendaraan Gagal Ditambahkan"
                ));
                return $result;
            }
            if ($slug == 'insert') {
                $motor = new Motor();
            }
            $motor->kendaraan_id = $kendaraan->_id;
            $motor->mesin = $data->getmesin();
            $motor->tipe_suspensi = $data->gettipeSuspensi();
            $motor->tipe_transmisi = $data->gettipeTransmisi();
            if (!$motor->save()) {
                $result->setresponseMessage("Failed");
                $result->setrespinseReason(array(
                    "english" => "Vehicle Data Failed to Add",
                    "indonesia" => "Data Kendaraan Gagal Ditambahkan"
                ));
                return $result;
            }

            $result->setrespinseReason(array(
                "english" => "Data Added Successfully",
                "indonesia" => "Data Berhasil Ditambahkan"
            ));
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }

    }

    public function getAll()
    {
        $data = Motor::all();
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