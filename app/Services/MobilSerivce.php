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
            $mobil->merk = $data->getmerk();
            $mobil->mesin = $data->getmesin();
            $mobil->kapasitas_penumpang = $data->getkapasitasPenumpang();
            $mobil->tipe = $data->gettipe();
            $mobil->status = $result->getstatus();
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
            $stoks[$item->merk]['details'][$item->_id]['kapasitas_penumpang'] = $item->kapasitas_penumpang;
            $stoks[$item->merk]['details'][$item->_id]['tipe'] = $item->tipe;
            $stoks[$item->merk]['details'][$item->_id]['kendaraan']['tahun_keluaran'] = $item->kendaraan->tahun_keluaran;
            $stoks[$item->merk]['details'][$item->_id]['kendaraan']['warna'] = $item->kendaraan->warna;
            $stoks[$item->merk]['details'][$item->_id]['kendaraan']['harga'] = $item->kendaraan->harga;
            $mesin = $item->merk;
        }
        return $stoks;
    }

    public function getAll()
    {
        $data = Mobil::all();
        return $data;
    }

    public function getAllAvailable()
    {
        $data = Mobil::where('status', '=', 'Available')->get();
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