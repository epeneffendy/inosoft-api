<?php

namespace App\Http\Controllers;

use App\Models\KendaraanMotorRequest;
use App\Models\KendaraanMotorResponse;
use App\Services\KendaraanService;
use App\Services\MotorSerivce;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Illuminate\Validation\ValidationException;

class MotorController extends Controller
{
    public function index(MotorSerivce $motorSerivce)
    {
        $motors = $motorSerivce->getAll();
        if (count($motors) > 0) {
            $data_motor = $this->arr_data($motors);

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
                    "english" => "Data Failed to Delete",
                    "indonesia" => "Data Gagal Dihapus"
                ],
                'data' => [],
            ];
        }

        return response()->json($response, 200);
    }

    public function store(Request $request, MotorSerivce $motorSerivce)
    {
        $validator = validator($request->all(), [
            'mesin' => ['required', 'string', 'max:20'],
            'tipeSuspensi' => ['required', 'string', 'max:20'],
            'tipeTransmisi' => ['required', 'string', 'max:20'],
            'kendaraan' => ['array']
        ], [], [
            'mesin' => 'Mesin',
            'tipeSuspensi' => 'Tipe Suspensi',
            'tipeTransmisi' => 'Tipe Transmisi',

        ]);

        try {
            $param = $validator->validated();
            $data = new KendaraanMotorRequest($request->all());
            $result = new KendaraanMotorResponse($request->all());
            $result = $motorSerivce->storeMotor($data, $result, $request->all(), 'insert');

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

    public function update(Request $request, MotorSerivce $motorSerivce, $id)
    {
        $validator = validator($request->all(), [
            'mesin' => ['required', 'string', 'max:20'],
            'tipeSuspensi' => ['required', 'string', 'max:20'],
            'tipeTransmisi' => ['required', 'string', 'max:20'],
            'kendaraan' => ['array']
        ], [], [
            'mesin' => 'Mesin',
            'tipeSuspensi' => 'Tipe Suspensi',
            'tipeTransmisi' => 'Tipe Transmisi',

        ]);

        try {
            $param = $validator->validated();
            $data = new KendaraanMotorRequest($request->all());
            $result = new KendaraanMotorResponse($request->all());

            $motor = $motorSerivce->findById($id);
            if (isset($motor)) {
                $result = $motorSerivce->storeMotor($data, $result, $request->all(), 'update', $motor);
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

    public function destroy(MotorSerivce $motorSerivce, KendaraanService $kendaraanService, $id)
    {
        $motor = $motorSerivce->findById($id);
        if (isset($motor)) {
            $kendaraanService->delete($motor->kendaraan->_id);
            $motorSerivce->delete($id);

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

    public function show(MotorSerivce $motorSerivce, $id)
    {
        $motor = $motorSerivce->findById($id);
        if (isset($motor)) {
            $data_motor = $this->arr_data($motor, true);

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

    public function arr_data($datas, $show = false)
    {
        $data_motor = [];
        if ($show){
            $data_motor[$datas->_id]['_id'] = $datas->_id;
            $data_motor[$datas->_id]['tipe_suspensi'] = $datas->tipe_suspensi;
            $data_motor[$datas->_id]['tipe_transmisi'] = $datas->tipe_transmisi;
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
                $data_motor[$item->_id]['tipe_suspensi'] = $item->tipe_suspensi;
                $data_motor[$item->_id]['tipe_transmisi'] = $item->tipe_transmisi;
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
