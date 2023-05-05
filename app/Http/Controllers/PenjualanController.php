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
use JWTAuth;
use MongoDB\Driver\Exception\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;

class PenjualanController extends Controller
{
    protected $user;

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
            $this->user = JWTAuth::parseToken()->authenticate();
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
            $response = [
                'responseCode' => 400,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Bad Request ",
                    "indonesia" => "Permintaan Tidak Valid"
                ],
                'error' =>  $validator->errors()
            ];
            return response()->json($response, 400);
        } catch (Exception $e) {
            $response = [
                'responseCode' => 400,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Bad Request ",
                    "indonesia" => "Permintaan Tidak Valid"
                ],
                'error' =>  $e->getMessage()
            ];
            return response()->json($response, 400);
        }catch (JWTException $e) {
            $response = [
                'responseCode' => 401,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Access Token Invalid",
                    "indonesia" => "Token Tidak Valid"
                ],
            ];
            return response()->json($response, 401);
        }
    }

    public function index(PenjualanService $penjualanService, $col, $value)
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
            $fetch = $penjualanService->fetchLaporan($col, $value);
            if (count($fetch) > 0) {
                $response = [
                    'responseCode' => 200,
                    'responseMessage' => 'Successful',
                    'responseReason' => [
                        "english" => "Success",
                        "indonesia" => "Sukses"
                    ],
                    'data' => $fetch,
                ];
            } else {
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
        }catch (JWTException $e) {
            $response = [
                'responseCode' => 401,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Access Token Invalid",
                    "indonesia" => "Token Tidak Valid"
                ],
            ];
            return response()->json($response, 401);
        } catch (Exception $e) {
            $response = [
                'responseCode' => 400,
                'responseMessage' => 'Failed',
                'responseReason' => [
                    "english" => "Bad Request ",
                    "indonesia" => "Permintaan Tidak Valid"
                ],
                'error' => $e->getMessage()
            ];
            return response()->json($response, 400);
        }

    }


}
