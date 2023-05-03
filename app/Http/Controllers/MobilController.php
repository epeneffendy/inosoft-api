<?php

namespace App\Http\Controllers;

use App\Models\KendaraanMobilRequest;
use App\Models\KendaraanMobilResponse;
use App\Models\Mobil;
use App\Services\KendaraanService;
use App\Services\MobilSerivce;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MongoDB\Driver\Exception\Exception;

class MobilController extends Controller
{
    public function index(MobilSerivce $mobilSerivce)
    {
        $mobils = $mobilSerivce->getAll();
        if (count($mobils) > 0) {
            $data_motor = $this->arr_data($mobils);
            $response = [
                'responseCode' => 200,
                'responseMessage' => 'Successful',
                'responseReason' => [
                    "english" => "Success",
                    "indonesia" => "Sukses"
                ],
                'data' => $data_motor,
            ];
        } else {
            $response = [
                'responseCode' => 200,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Data Not Found",
                    "indonesia" => "Data Tidak Ditemukan"
                ],
                'data' => [],
            ];
        }

        return response()->json($response, 200);
    }

    public function store(Request $request, MobilSerivce $mobilSerivce)
    {
        $validator = validator($request->all(), [
            'merk' => ['required', 'string', 'max:20'],
            'mesin' => ['required', 'string', 'max:20'],
            'kapasitasPenumpang' => ['required', 'numeric'],
            'tipe' => ['required', 'string', 'max:20'],
            'kendaraan' => ['array']
        ], [], [
            'merk' => 'Merk',
            'mesin' => 'Mesin',
            'kapasitasPenumpang' => 'Tipe Penumpang',
            'tipe' => 'Tipe',
        ]);

        try {
            $param =  $validator->validated();
            $data = new KendaraanMobilRequest($request->all());
            $result = new KendaraanMobilResponse($request->all());
            $result = $mobilSerivce->storeMobil($data, $result, $request->all(), 'insert');

            $response = $result->toArray();
            return response()->json($response, 200);
        } catch (ValidationException $e) {
            return response()
                ->json([
                    'error' => $validator->errors(),
                    'code' => 400
                ], 400);
        } catch (Exception $e) {
            return response()
                ->json([
                    'error' => $e->getMessage(),
                    'code' => 400
                ], 400);
        }
    }

    public function update(Request $request, MobilSerivce $mobilSerivce, $id)
    {
        $validator = validator($request->all(), [
            'mesin' => ['required', 'string', 'max:20'],
            'kapasitasPenumpang' => ['required', 'numeric'],
            'tipe' => ['required', 'string', 'max:20'],
            'kendaraan' => ['array']
        ], [], [
            'mesin' => 'Mesin',
            'kapasitasPenumpang' => 'Tipe Penumpang',
            'tipe' => 'Tipe',
        ]);

        try {
            $param = $validator->validated();
            $data = new KendaraanMobilRequest($request->all());
            $result = new KendaraanMobilResponse($request->all());

            $mobil = $mobilSerivce->findById($id);
            if (isset($mobil)) {
                $result = $mobilSerivce->storeMobil($data, $result, $request->all(), 'update', $mobil);
            } else {
                $result->setresponseMessage("Failed");
                $result->setresponseReason(array(
                    "english" => "Data Not Found",
                    "indonesia" => "Data Tidak Ditemukan"
                ));
            }

            $response = $result->toArray();
            return response()->json($response, 200);
        } catch (ValidationException $e) {
            return response()
                ->json([
                    'error' => $validator->errors(),
                    'code' => 400
                ], 400);
        } catch (Exception $e) {
            return response()
                ->json([
                    'error' => $e->getMessage(),
                    'code' => 400
                ], 400);
        }
    }

    public function destroy(MobilSerivce $mobilSerivce, KendaraanService $kendaraanService, $id)
    {
        $mobil = $mobilSerivce->findById($id);
        if (isset($mobil)) {
            $kendaraanService->delete($mobil->kendaraan->_id);
            $mobilSerivce->delete($id);

            $response = [
                'responseCode' => 200,
                'responseMessage' => 'Successful',
                'responseReason' => [
                    "english" => "Data Deleted Successfully",
                    "indonesia" => "Data Berhasil Dihapus"
                ]
            ];
        } else {
            $response = [
                'responseCode' => 200,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Data Not Found",
                    "indonesia" => "Data Tidak Ditemukan"
                ]
            ];
        }
        return response()->json($response, 200);
    }

    public function show(MobilSerivce $mobilSerivce, $id)
    {
        $mobil = $mobilSerivce->findById($id);
        if (isset($mobilSerivce)) {
            $data_mobil = $this->arr_data($mobil, true);

            $response = [
                'responseCode' => 200,
                'responseMessage' => 'Successful',
                'responseReason' => [
                    "english" => "Success",
                    "indonesia" => "Sukses"
                ],
                'data' => $data_mobil,
            ];
        } else {
            $response = [
                'responseCode' => 200,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Data Not Found",
                    "indonesia" => "Data Tidak Ditemukan"
                ],
                'data' => [],
            ];
        }

        return response()->json($response, 200);
    }

    public function arr_data($datas, $show = false)
    {
        $data_motor = [];
        if ($show){
            $data_motor[$datas->_id]['_id'] = $datas->_id;
            $data_motor[$datas->_id]['merk'] = $datas->merk;
            $data_motor[$datas->_id]['mesin'] = $datas->mesin;
            $data_motor[$datas->_id]['kapasitas_penumpang'] = $datas->kapasitas_penumpang;
            $data_motor[$datas->_id]['tipe'] = $datas->tipe;
            $data_motor[$datas->_id]['status'] = $datas->status;
            if (isset($datas->kendaraan)) {
                $data_motor[$datas->_id]['kendaraan']['tahun_keluaran'] = $datas->kendaraan->tahun_keluaran;
                $data_motor[$datas->_id]['kendaraan']['warna'] = $datas->kendaraan->warna;
                $data_motor[$datas->_id]['kendaraan']['harga'] = $datas->kendaraan->harga;
            } else {
                $data_motor[$datas->_id]['kendaraan'] = [];
            }
        }else{
            foreach ($datas as $item) {
                $data_motor[$item->_id]['_id'] = $item->_id;
                $data_motor[$item->_id]['merk'] = $item->merk;
                $data_motor[$item->_id]['mesin'] = $item->mesin;
                $data_motor[$item->_id]['kapasitas_penumpang'] = $item->kapasitas_penumpang;
                $data_motor[$item->_id]['tipe'] = $item->tipe;
                $data_motor[$item->_id]['status'] = $item->status;
                if (isset($item->kendaraan)) {
                    $data_motor[$item->_id]['kendaraan']['tahun_keluaran'] = $item->kendaraan->tahun_keluaran;
                    $data_motor[$item->_id]['kendaraan']['warna'] = $item->kendaraan->warna;
                    $data_motor[$item->_id]['kendaraan']['harga'] = $item->kendaraan->harga;
                } else {
                    $data_motor[$item->_id]['kendaraan'] = [];
                }
            }
        }
        return $data_motor;
    }
}
