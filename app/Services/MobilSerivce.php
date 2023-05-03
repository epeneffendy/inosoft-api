<?php
namespace App\Services;

use App\Models\Kendaraan;
use App\Models\KendaraanMobilRequest;
use App\Models\KendaraanMobilResponse;
use App\Models\Mobil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MobilSerivce
{
    public function storeMobil(KendaraanMobilRequest $data, KendaraanMobilResponse $result, $request, $slug, $mobil = null)
    {
        try {
            $kendaraan = new Kendaraan();
            if ($slug == 'update') {
                $kendaraan = Kendaraan::where('_id', '=', $mobil->kendaraan->_id)->first();
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
                $mobil = new Mobil();
            }
            $mobil->kendaraan_id = $kendaraan->_id;
            $mobil->mesin = $data->getmesin();
            $mobil->kapasitas_penumpang = $data->getkapasitasPenumpang();
            $mobil->tipe = $data->gettipe();
            if (!$mobil->save()) {
                $result->setresponseMessage("Failed");
                $result->setresponseReason(array(
                    "english" => "Car Data Failed to Add",
                    "indonesia" => "Data Mobil Gagal Ditambahkan"
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
        $datas = $this->getAll();
        $mesin = '';
        $jumlah = 1;
        foreach ($datas as $item) {
            if ($mesin == $item->mesin) {
                $jumlah++;
            } else {
                $jumlah = 1;
            }

            $stoks[$item->mesin]['mesin'] = $item->mesin;
            $stoks[$item->mesin]['stok'] = $jumlah;
            $stoks[$item->mesin]['details'][$item->_id]['mesin'] = $item->mesin;
            $stoks[$item->mesin]['details'][$item->_id]['kapasitas_penumpang'] = $item->kapasitas_penumpang;
            $stoks[$item->mesin]['details'][$item->_id]['tipe'] = $item->tipe;
            $stoks[$item->mesin]['details'][$item->_id]['kendaraan']['tahun_keluaran'] = $item->kendaraan->tahun_keluaran;
            $stoks[$item->mesin]['details'][$item->_id]['kendaraan']['warna'] = $item->kendaraan->warna;
            $stoks[$item->mesin]['details'][$item->_id]['kendaraan']['harga'] = $item->kendaraan->harga;
            $mesin = $item->mesin;
        }

        return $stoks;
    }

    public function getAll()
    {
        $data = Mobil::all();
        return $data;
    }

    public function findById($id)
    {
        $data = Mobil::where('_id', '=', $id)->first();
        return $data;
    }

    public function delete($id)
    {
        $data = $this->findById($id);
        $data->delete();
    }
}