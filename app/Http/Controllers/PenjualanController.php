<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanKendaraanRequest;
use App\Models\PenjualanKendaraanResponse;
use App\Services\MobilSerivce;
use App\Services\MotorSerivce;
use App\Services\PenjualanService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PenjualanController extends Controller
{
    public function store(Request $request, MotorSerivce $motorSerivce, MobilSerivce $mobilSerivce, PenjualanService $penjualanService)
    {
        $validator = validator($request->all(), [
            'type' => ['required', 'string', 'max:20'],
            'kendaraan_ids' => ['required', 'string', 'max:20'],
            'tanggal' => ['required', 'date_format:Y-m-d', 'max:20'],
        ], [], [
            'Type' => 'Type',
            'kendaraan_ids' => 'ID Mobil/Motor',
            'tanggal' => 'Tanggal',
        ]);

        try {
            $validator->validated();
            $data = new PenjualanKendaraanRequest($request->all());
            $result = new PenjualanKendaraanResponse($request->all());
            if ($request->type == 'mobil') {
                $kendaraan = $mobilSerivce->findById($request->kendaraanIds);
            } else {
                $kendaraan = $motorSerivce->findById($request->kendaraanIds);
            }

            if (isset($kendaraan)) {
                $result = $penjualanService->storePenjualan($data, $result, $mobilSerivce, $motorSerivce);
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
        } catch (\Exception $e) {
            return response()
                ->json([
                    'error' => $validator->errors(),
                    'code' => 400
                ], 400);
        }
    }

    public function index(PenjualanService $penjualanService, $col, $value)
    {
        $fetch = $penjualanService->fetchLaporan($col, $value);
        if (count($fetch) > 0){
            $response = [
                'responseCode' => 200,
                'responseMessage' => 'Successful',
                'responseReason' => [
                    "english" => "Success",
                    "indonesia" => "Sukses"
                ],
                'data' => $fetch,
            ];
        }else{
            $response = [
                'responseCode' => 200,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Data Not Foundsss",
                    "indonesia" => "Data Tidak Ditemukan"
                ],
                'data' => [],
            ];
        }
        return response()->json($response, 200);
    }


}
